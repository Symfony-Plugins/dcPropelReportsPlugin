<?php

/**
 * dc_report_condition actions.
 *
 * @package    crPropelreport
 * @subpackage dc_report_condition
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class dc_report_conditionActions extends sfActions
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

  private function getConditionObject($group_criteria)
  {
    $std=new stdClass;
    $std->group_criteria=$group_criteria;
    $std->report_criterias=array();
    foreach($group_criteria->getdcReportCriterias() as $rc)
    {
      $std->report_criterias[$rc->getId()]=$rc;
    }
    return $std;
  }

  
  private function findConditionObject($group_criteria_id)
  {
    $this->conditions=$this->getConditions();
    return array_key_exists($group_criteria_id,$this->conditions)?$this->conditions[$group_criteria_id ]:null;
  }

  protected function initializeConditions()
  {
    $conditions=array();
    foreach($this->report_query->getdcReportGroupCriterias() as $gc)
    {
      $conditions[$gc->getid()]=$this->getConditionObject($gc);
    }
    $this->setConditions($conditions);
  }

  protected function getConditions()
  {
    return unserialize($this->getUser()->getAttribute("/dc_report_conditions/report_query/".$this->report_query."/private", serialize(array())));
  }
  protected function setConditions($c)
  {
    return $this->getUser()->setAttribute("/dc_report_conditions/report_query/".$this->report_query."/private", serialize($c));
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->initializeConditions();
    $this->conditions=$this->getConditions();
  }

  public function executeAddEmptyGroupCriteria(sfWebRequest $request)
  {
    $this->conditions=$this->getConditions();
    if ($request->isMethod('post'))
    {
      $newgc=new dcReportGroupCriteria();
      $newgc->setId($this->generateIdFor($newgc));
      $newgc->setdcReportQuery($this->report_query);
      
      $this->conditions[$newgc->getId()]=$std=$this->getConditionObject($newgc);
      $this->setConditions($this->conditions);
      $this->renderPartial('dc_report_condition/group_criteria',array("group_criteria"=>$std->group_criteria,'report_criterias'=>$std->report_criterias));
    }
    return sfView::NONE;
  }

  public function executeRemoveGroupCriteria(sfWebRequest $request)
  {
    $this->conditions=$this->getConditions();
    if ($request->isMethod('post'))
    {
      $id=$request->getParameter('group_criteria');
      foreach($this->conditions as $key=>$std)
      {
        if ($key == $id)
        {
          unset($this->conditions[$key]);
          $this->setConditions($this->conditions);
          return sfView::NONE;
        }
      }
    }
    $this->forward404();
  }

  public function executeRemoveReportCriteria(sfWebRequest $request)
  {
    $this->conditions=$this->getConditions();
    if ($request->isMethod('post'))
    {
      $g_crit=$request->getParameter('group_criteria');
      $r_crit=$request->getParameter('report_criteria');
      $co=$this->findConditionObject($g_crit);
      if (!is_null($co))
      {
        $report_criterias=$co->report_criterias;
        unset($report_criterias[$r_crit]);
        $co->report_criterias=$report_criterias;
        $this->conditions[$g_crit]=$co;
        $this->setConditions($this->conditions);
        return sfView::NONE;
      }
    }
    $this->forward404();
  }

  public function executeAddReportCriteria(sfWebRequest $request)
  {
    if ($request->isMethod('post'))
    {
      $id=$request->getParameter('group_criteria');
      $this->conditions=$this->getConditions();
      $co=$this->findConditionObject($id);
      if (!is_null($co))
      { 
        $group_criteria=$co->group_criteria;
        $this->form= new dcReportCriteriaForm($group_criteria->getNewReportCriteria());  
        $this->form->bind($request->getParameter("dc_report_criteria[$id]"),$request->getFiles("dc_report_criteria[$id]"));
        if ($this->form->isValid())
        {
          $this->form->updateObject();
          $newrc=$this->form->getObject();
          $newrc->setId($this->generateIdFor($newrc));
          $this->conditions[$id]->report_criterias[$newrc->getId()]=$newrc;
          $this->setConditions($this->conditions);
          $this->renderPartial('dc_report_condition/report_criterias',array("group_criteria"=>$co->group_criteria,'report_criterias'=>$co->report_criterias, 'form'=>new dcReportCriteriaForm($group_criteria->getNewReportCriteria())));
        }
        else
        {
          $this->getUser()->setFlash('error','Error adding report criteria');
          $this->renderPartial('dc_report_condition/report_criterias',array("group_criteria"=>$co->group_criteria,'report_criterias'=>$co->report_criterias, 'form'=>$this->form));
        }
        $co=$this->conditions[$id];
        return sfView::NONE;
      }
      else
      {
        $this->getUser()->setFlash('error','Error adding report criteria');
      }
    }
    else
    {
      $this->getUser()->setFlash('error','Error adding report criteria');
    }
    /* TODO: Implements error template for this action */
    return sfView::ERROR;
  }


  private function generateIdFor($object)
  {
    $ids=$this->getUser()->getAttribute("/dc_report_conditions/report_query/".$this->report_query."/genIds",array());
    if (!array_key_exists(get_class($object),$ids))
    {
      $ids[get_class($object)]=0;
    }
    $ids[get_class($object)]-=1;
    $this->getUser()->setAttribute("/dc_report_conditions/report_query/".$this->report_query."/genIds",$ids);
    return  $ids[get_class($object)];
  }

  public function executeSave(sfWebRequest $request)
  {
    if ($request->isMethod('post'))
    {
      $this->conditions=$this->getConditions();
      $con = Propel::getConnection(dcReportQueryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
      $con->beginTransaction();
      try
      {
        foreach($this->report_query->getdcReportGroupCriterias(null,$con) as $gc)
        {
          $gc->delete($con);
        }
        foreach($this->conditions as $std)
        {
          if (!empty($std->report_criterias))
          {
            $gc=new dcReportGroupCriteria();
            $gc->setdcReportQuery($this->report_query);
            foreach($std->report_criterias as $rc)
            {
              $new_rc=new dcReportCriteria();
              $new_rc->setdcReportGroupCriteria($gc);
              $new_rc->setdcReportTableId($rc->getdcReportTableId());
              $new_rc->setColumn($rc->getColumn());
              $new_rc->setOperation($rc->getOperation());
              $new_rc->setValue($rc->getValue());
            }
            $gc->save($con);
          }
        }
        $con->commit();
        $this->getUser()->setFlash('notice','Conditions updated');
        $this->setConditions(array());
      }catch(PropelException $e) {
        $con->rollBack();
        $this->getUser()->setFlash('error',"Error writing conditions");
        var_dump($e->getMessage());die();
      }
    }
    $this->redirect('dc_report_condition/index');
  }

  public function executeBackToQuery(sfWebRequest $request)
  {
    $this->redirect('@dc_report_query');
  }

}
