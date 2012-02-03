<?php $i=0; ?>
<?php foreach($row as $key=>$field): ?>
<?php $wrapper = $column_wrappers[$i]; ?>
<?php $wrapper->setValue($field); ?>
<?php if ( $fields_definition[$key]->getDisplayInResults()): ?>
<td class="sf_admin_text">
  <?php echo $wrapper->getValue(dcPropelReportColumnWrapper::FORMAT_HTML); ?>
</td>
<?php endif?>
<?php $i++; ?>
<?php endforeach ?>
