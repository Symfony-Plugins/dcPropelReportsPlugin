<?php

require_once dirname(__FILE__).'/../lib/dc_report_tableGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dc_report_tableGeneratorHelper.class.php';

/**
 * dc_report_table actions.
 *
 * @package    crPropelreport
 * @subpackage dc_report_table
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_report_tableActions extends autoDc_report_tableActions
{
  public function preExecute()
  {
    parent::preExecute();
    $this->report_query=dcReportQueryPeer::retrieveByPk($this->getUser()->getAttribute('dc_report_query/current_report'));
    if (is_null($this->report_query))
    {
      $this->getUser()->setFlash('error','Error accessing tables');
      $this->redirect('@dc_report_query');
    }
  }

  public function executeEdit(sfWebRequest $request)
  {
    $notice=$this->getUser()->getFlash('notice');
    if (!empty($notice))
    {
      $this->getUser()->setFlash('notice',$notice);
    } 
    $error=$this->getUser()->getFlash('error');
    if (!empty($error))
    {
      $this->getUser()->setFlash('error',$error);
    }
    $this->redirect('@dc_report_table');
  }

  public function executeBackToQuery(sfWebRequest $request)
  {
      $this->redirect('@dc_report_query');
  }


  public function executeGetColumnOptionsForTable(sfWebRequest $request)
  {
    $this->getResponse()->setHttpHeader('Content-Type','application/json; charset=utf-8');
    $output = array();
    if ($request->isMethod('post'))
    {
      $dc_report_table=dcReportTablePeer::retrieveByPk($request->getParameter('table'));
      if (is_null($dc_report_table))
      {
        $table=$request->getParameter('table'); 
      }
      else
      {
        $table=$dc_report_table->getPropelName();
      }
      $table_map=dcPropelReflector::getTableMap($table,$this->report_query->getDatabase());
      foreach(dcPropelReflector::getColumnsAsOptions($table_map) as $id=>$value)
      {
        $output[]=array("id"=>$id,"value"=>$value);
      }
    }
    return $this->renderText(json_encode($output));
  }

  public function executeList_delete(sfWebRequest $request)
  {
    $table=dcReportTablePeer::getLast($this->report_query);
    if (!is_null($table))
    {
      $table->delete();
      $this->getUser()->setFlash('notice','Last relation deleted successfuly');
      $this->redirect('@dc_report_table');
    }
    $this->getUser()->setFlash('error','Error deleting last relation');
    $this->redirect('@dc_report_table');

  }

  public function executeIndex(sfWebRequest $request)
  {
	$c = new Criteria();
	$c->add(dcReportRelationPeer::DC_REPORT_QUERY_ID,$this->report_query->getId());
        $c->addAscendingOrderByColumn(dcReportRelationPeer::ID);
	$this->relations = dcReportRelationPeer::doSelect($c);

	$c = new Criteria();
	$c->add(dcReportTablePeer::DC_REPORT_QUERY_ID,$this->report_query->getId());
        $c->addAscendingOrderByColumn(dcReportTablePeer::ID);
	$this->tables = dcReportTablePeer::doSelect($c);
  }
    
}
