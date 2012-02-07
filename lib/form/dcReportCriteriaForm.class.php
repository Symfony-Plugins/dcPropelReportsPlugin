<?php

/**
 * dcReportCriteria form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class dcReportCriteriaForm extends BasedcReportCriteriaForm
{

  public function configure()
  {
    if ( isset($this['created_at']) ) unset($this['created_at']);
    if ( isset($this['updated_at']) ) unset($this['updated_at']);
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
    $this->setWidget('dc_report_group_criteria_id', new sfWidgetFormInputHidden());
    $this->validatorSchema['dc_report_group_criteria_id'] = new sfValidatorNumber();

    $criteria=new Criteria();
    $criteria->add(dcReportTablePeer::DC_REPORT_QUERY_ID,$this->getObject()->getdcReportQueryId());
    $this->getWidget('dc_report_table_id')->addOption('criteria',$criteria);
    $this->getWidget('dc_report_table_id')->addOption('add_empty',true);
    $this->getWidget('dc_report_table_id')->setAttribute('onchange',strtr(
         "new Ajax.Request('%url%',
            {
                onLoading: function () { 
                    %loading%
                },
                onComplete: function (request) { 
                    %complete%
                },
                parameters: %params%
             })", array(
          '%url%'=>'dc_report_table/getColumnOptionsForTable',
          '%loading%'  => "$('dc_report_criteria_".$this->getObject()->getdcReportGroupCriteriaId()."__column').disable()",
          '%complete%' => "dc_propel_relation_update_columns_JSON(request,$('dc_report_criteria_".$this->getObject()->getdcReportGroupCriteriaId()."__column'));$('dc_report_criteria_".$this->getObject()->getdcReportGroupCriteriaId()."__column').enable()",
          '%params%'=>"'table='+$(this).getValue()"
        )));
    $this->setWidget('column',new sfWidgetFormChoice(array(
      'choices'=>array()
    )));
    $this->setWidget('operation',new sfWidgetFormChoice(array(
      'choices'=> dcReportCriteria::$codes,
    )));
    $this->widgetSchema->setHelp('value','For IN or NOT IN condition, write each value separated by a coma (,)');
    $this->widgetSchema->setNameFormat('dc_report_criteria_'.$this->getObject()->getdcReportGroupCriteriaId().'_[%s]');
    $this->widgetSchema->setLabel('dc_report_table_id','Table');
  }

  public function getJavaScripts()
  {
    return array_merge(
      parent::getJavaScripts(),
      array('/dcPropelReportsPlugin/js/prototype.js', '/dcPropelReportsPlugin/js/dc_propel_table.js')
    );
  }


}
