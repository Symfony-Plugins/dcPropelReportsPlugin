<?php use_helper('I18N', 'Date') ?>
<?php use_stylesheet('/sfPropelPlugin/css/global.css', 'first') ?>
<?php use_stylesheet('/sfPropelPlugin/css/default.css', 'first') ?>
<?php use_stylesheet('/dcPropelReportsPlugin/css/condition.css', 'first') ?>
<?php use_javascript('/dcPropelReportsPlugin/js/dc_propel_table.js') ?>
<div id="sf_admin_container">
  <h1><?php echo __('Manage conditions', array(), 'messages') ?></h1>

  <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></div>
  <?php endif; ?>

  <?php if ($sf_user->hasFlash('error')): ?>
    <div class="error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></div>
  <?php endif; ?>


  <div id="sf_admin_content">
    
    <?php include_partial('dc_report_condition/conditions',array("conditions"=>$conditions))?>

  </div>

  <div id="sf_admin_footer">
  </div>
</div>

