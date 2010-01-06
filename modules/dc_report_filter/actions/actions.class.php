<?php

require_once dirname(__FILE__).'/../lib/dc_report_filterGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dc_report_filterGeneratorHelper.class.php';

/**
 * dc_report_filter actions.
 *
 * @package    prototype
 * @subpackage dc_report_filter
 * @author     ncuesta
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_report_filterActions extends autoDc_report_filterActions
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

  public function executeTypeChange($request)
  {
  		$dc_report_query_id = $request->getParameter('dc_report_query_id');
  		$type = $request->getParameter('type');
  		$filter  = new dcReportFilter();
  		$filter->setDcReportQueryId($dc_report_query_id);
  		$filter->setFilterType(($type=="")?0:$type);
  		$form = new dcReportFilterForm($filter);
 		$this->form = $form;
  }

}
