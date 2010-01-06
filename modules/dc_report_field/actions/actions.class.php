<?php

require_once dirname(__FILE__).'/../lib/dc_report_fieldGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dc_report_fieldGeneratorHelper.class.php';

/**
 * dc_report_field actions.
 *
 * @package    prueba
 * @subpackage dc_report_field
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_report_fieldActions extends autoDc_report_fieldActions
{

  public function preExecute()
  {
    parent::preExecute();
    $this->report_query=dcReportQueryPeer::retrieveByPk($this->getUser()->getAttribute('dc_report_query/current_report'));
    if (is_null($this->report_query))
    {
      $this->getUser()->setFlash('error','Error accessing fields');
      $this->redirect('@dc_report_query');
    }
  }
  
  public function executeBackToQuery(sfWebRequest $request)
  {
      $this->redirect('@dc_report_query');
  }
  
  public function executeTableChange($request)
  {
  		$dc_report_query_id = $request->getParameter('dc_report_query_id');
  		$table = $request->getParameter('table');
  		$field  = new dcReportField();
  		$field->setDcReportQueryId($dc_report_query_id);
  		$field->setDcReportTableId(($table=="")?null:$table);
  		$form = new dcReportFieldForm($field);
 		$this->form = $form;
  }
  
  
  
  
}
