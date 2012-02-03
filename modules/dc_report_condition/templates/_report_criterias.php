<?php use_helper('JavascriptBase','I18N')?>
<ul>
<?php if (empty($report_criterias)): ?>
<li><em><?php echo __('No conditions defined')?></em></li>
<?php else: ?>
  <?php foreach( $report_criterias as $rc): ?>
    <li id="report_criteria_<?php echo $group_criteria->getId()?>_<?php echo $rc->getId()?>">
      <?php echo link_to_function(image_tag('/dcPropelReportsPlugin/images/report_criteria_delete'),
          strtr("new Ajax.Request('%url%',
                    {
                        parameters: %params%,
                        onSuccess: %success%, 
                    })", array(
            '%url%'=>'dc_report_condition/removeReportCriteria',
            '%params%'=>"'group_criteria=".$group_criteria->getId()."&report_criteria=".$rc->getId()."'",
            '%success%'=>"$('report_criteria_".$group_criteria->getId()."_".$rc->getId()."').remove()"
          )))
      ?>
      
      <?php echo $rc->getRealColumnName().' <strong>'.dcReportCriteria::getOperationString($rc->getOperation()).'</strong> <em>'.$rc->getValue().'</em>' ?>

    </li>
  <?php endforeach?>
<?php endif ?>
  <li><h2><?php echo link_to_function(image_tag('/dcPropelReportsPlugin/images/report_criteria_add').' '.__('Add condition'),'$("report_criteria_form_'.$group_criteria->getId().'").toggle()')?></h2>
    <fieldset id="report_criteria_form_<?php echo $group_criteria->getId()?>" <?php if (!$form->hasErrors()): ?>style="display: none"<?php endif?> >
      <?php echo form_tag('/dc_report_condition/addReportCriteria') ?>
      <?php echo $form->renderHiddenFields() ?>
      <?php foreach (array('dc_report_table_id','column','operation','value') as $name): ?>
      <div class="sf_admin_form-row <?php $form[$name]->hasError() and print ' errors' ?>" >
        <div>
          <?php echo $form[$name]->renderError() ?>
          <?php echo $form[$name]->renderLabel() ?>
          <div class="content">
          <?php echo $form[$name] ?>
          </div>
          <div class="help">
          <?php echo $form[$name]->renderHelp() ?>
          </div>
        </div>
      </div>
      <?php endforeach?>
      <ul class="sf_admin_actions">
      <li class="sf_admin_action_save">
      <?php echo button_to_function('Add', strtr("
          new Ajax.Updater(
            '%id_to_update%','%url%',
            {
                parameters: %params% 
            })",
            array(
                '%url%'           => 'dc_report_condition/addReportCriteria?group_criteria='.$group_criteria->getId(),
                '%id_to_update%'  => 'report_criterias_'.$group_criteria->getId(),
                '%params%'        => 'Form.serialize(this.form)'
            ))); 
      ?>
      </li>
      <li class="sf_admin_action_delete">
        <?php echo link_to_function(__('Cancel'),'$("report_criteria_form_'.$group_criteria->getId().'").toggle()')?>
      </li>
      </ul>
    </fieldset>
  </li>
</ul>
