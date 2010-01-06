<?php

require_once dirname(__FILE__).'/../lib/dc_report_queryGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dc_report_queryGeneratorHelper.class.php';

/**
 * dc_report_query actions.
 *
 * @package    crPropelreport
 * @subpackage dc_report_query
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_report_queryActions extends autoDc_report_queryActions
{

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

    public function executeTables(sfWebRequest $request)
    {
      $this->setCurrentReportQuery();
      $this->redirect('@dc_report_table');
    }
    
    public function executeColumns(sfWebRequest $request)
    {
      $rquery=$this->getRoute()->getObject();
      if (is_null($rquery))
      {
        $this->getUser()->setFlash('error','Error accessing tables');
        $this->redirect('@dc_report_query');
      }
      $this->getUser()->setAttribute('dc_report_query/current_report',$rquery->getId());
      $this->redirect('@dc_report_field');
    }
    

    public function executeConditions(sfWebRequest $request)
    {
      $this->setCurrentReportQuery();
      $this->redirect('dc_report_condition/index');
    }

    public function executeFilters(sfWebRequest $request)
    {
      $this->setCurrentReportQuery();
      $this->redirect('dc_report_filter/index');
    }

    public function executePublish(sfWebRequest $request)
    {
      $rquery=$this->getRoute()->getObject();
      if ($rquery->canBePublished())
      {
        $rquery->setIsPublished(true);
        $rquery->save();
        $this->getUser()->setFlash('notice','The item was updated successfully.');
      }
      else
      {
        $this->getUser()->setFlash('error',"Query can't be published");
      }
      $this->redirect('@dc_report_query');
    }

    public function executeUnpublish(sfWebRequest $request)
    {
      $rquery=$this->getRoute()->getObject();
      if ($rquery->getIsPublished())
      {
        $rquery->setIsPublished(false);
        $rquery->save();
        $this->getUser()->setFlash('notice','The item was updated successfully.');
      }
      else
      {
        $this->getUser()->setFlash('error',"Query can't be unpublished");
      }
      $this->redirect('@dc_report_query');
    }

    public function executeShow(sfWebRequest $request)
    {
      $this->dc_report_query=$this->getRoute()->getObject();
    }


    public function executeTest(sfWebRequest $request)
    {
      $this->dc_report_query=$this->getRoute()->getObject();
      $this->redirect('@dc_report_list?name='.$this->dc_report_query->getName());
    }
    
}
