<?php use_helper('I18N', 'Date') ?>
<?php include_partial('dc_report_table/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Tables and relations', array(), 'messages') ?></h1>

  <?php include_partial('dc_report_table/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('dc_report_table/list_header', array()) ?>
  </div>


  <div id="sf_admin_content">
    <?php include_partial('dc_report_table/list', array('relations' => $relations,'tables'=>$tables, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('dc_report_table/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('dc_report_table/list_actions', array('helper' => $helper)) ?>
    </ul>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('dc_report_table/list_footer', array()) ?>
  </div>
</div>
