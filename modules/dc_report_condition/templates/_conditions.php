<?php use_helper('Javascript')?>
<div id="conditions_toolbar">
<?php echo link_to_remote(image_tag('/dcPropelReportsPlugin/images/group_criteria_add').' '.__('Add a new condition box'),
        array(
          'url'=>'dc_report_condition/addEmptyGroupCriteria',
          'update'=>"conditions_container",
          'position'=>'bottom',
    )); ?>
<?php echo link_to(image_tag('/sfPropelPlugin/images/default').' '.__('Back to query'),
          'dc_report_condition/backToQuery'); ?>
<?php echo link_to(image_tag('/dcPropelReportsPlugin/images/group_criteria_add').' '.__('Save'),
          'dc_report_condition/save',array('method'=>'post')); ?>
<div class="help"><?php echo __("Conditional boxes will be joined with logical OR")?>
</div>
</div>
<div id="conditions_container">
<?php foreach($conditions as $std): ?>
  <?php include_partial('dc_report_condition/group_criteria',array("group_criteria"=>$std->group_criteria,"report_criterias"=>$std->report_criterias)) ?>
<?php endforeach ?>  
</div>
