<?php use_helper('I18N', 'Date') ?>
<?php use_stylesheet('/sfPropelPlugin/css/global.css', 'first') ?>
<?php use_stylesheet('/sfPropelPlugin/css/default.css', 'first') ?>
<?php use_stylesheet('/dcPropelReportsPlugin/css/default.css', 'first') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Test Report:', array(), 'messages').' '.$report_query->getName() ?></h1>

   <?php include_partial('dc_report_list/filters', array('form' => $filters, 'dc_report_query'=>$report_query)) ?>

  <div id="sf_admin_bar">
 
  </div>

  <div id="sf_admin_content">
    <?php include_partial('dc_report_list/result', array('pager' => $pager, 
                                                         'export_pager' => $export_pager, 
                                                         'dc_report_query'=>$report_query,
                                                         'sort' => $sort)) ?>
  </div>


</div>                 
