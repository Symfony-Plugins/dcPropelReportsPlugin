<?php use_helper('Javascript','I18N')?>
<div id="condition_group_<?php echo $group_criteria->getId()?>" class="condition_group">
  <div class="condition_group_toolbar">
    <?php echo link_to_remote(image_tag('/dcPropelReportsPlugin/images/group_criteria_delete').' '.__('Remove conditional box'),
        array(
          'url'=>'dc_report_condition/removeGroupCriteria',
          'with'=>"'group_criteria='+".$group_criteria->getId(),
          'success'=>"$('condition_group_".$group_criteria->getId()."').remove()"
    ),array('confirm'=>__('Are you sure?'))); ?>
  <div class="help">
    <?php echo __('Conditions inside this box will be joined with logical AND')?>
  </div>
  </div>
  <div id="report_criterias_<?php echo $group_criteria->getId()?>">
    <?php include_partial('dc_report_condition/report_criterias',array("group_criteria"=>$group_criteria,'report_criterias'=>$report_criterias,'form'=>new dcReportCriteriaForm($group_criteria->getNewReportCriteria())))?>
  </div>
</div>
