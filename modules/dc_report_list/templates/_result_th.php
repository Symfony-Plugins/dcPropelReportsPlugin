<?php slot('sf_admin.current_header') ?>
<?php foreach ($dc_report_query->getdcReportFields() as $field): ?>

<th class="sf_admin_text">
  <?php $column=$field->__toString()?>
  <?php $column_id=$field->getId()?>
  <?php if ($column_id == $sort[0]): ?>
    <?php echo link_to(__($column, array(), 'messages'), 'dc_report_list/index', array('query_string' => "sort=$column_id&sort_type=".($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__($column, array(), 'messages'), 'dc_report_list/index', array('query_string' => "sort=$column_id&sort_type=asc")) ?>
  <?php endif; ?>
</th>

<?php endforeach?>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>
