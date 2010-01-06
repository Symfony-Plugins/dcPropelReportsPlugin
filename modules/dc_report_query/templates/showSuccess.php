<?php use_helper('I18N', 'Date') ?>
<?php include_partial('dc_report_query/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Show sql', array(), 'messages') ?></h1>

  <div id="sf_admin_content">
    <div class="sql">
    <?php echo $dc_report_query->getSql() ?> 
    </div>
    <ul class="sf_admin_actions">
      <?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
    </ul>
  </div>

</div>

