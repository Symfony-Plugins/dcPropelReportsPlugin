<?php

require_once dirname(__FILE__).'/../lib/dc_report_publicGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dc_report_publicGeneratorHelper.class.php';

/**
 * dc_report_query actions.
 *
 * @package    crPropelreport
 * @subpackage dc_report_query
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_report_publicActions extends autoDc_report_publicActions
{

    public function buildCriteria()
    {
	$criteria = parent::buildCriteria();
	$criteria->add(dcReportQueryPeer::IS_PUBLISHED,true);
	return $criteria;
    }

     private function setCurrentReportQuery()
    {
      $rquery=$this->getRoute()->getObject();
      if (is_null($rquery))
      {
        $this->getUser()->setFlash('error','Error accessing tables');
        $this->redirect('@dc_report_query');
      }
      $this->getUser()->setAttribute('dc_report_query/current_report',$rquery->getId());
    }
    
}
