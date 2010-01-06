<td colspan="1">
<?php if ($dc_report_relation->getId() == $pri->getId()):?>
	<em>
	<?php echo $dc_report_relation->getDcReportTableRelatedByDcReportTableLeft(); ?>
	</em>
	<br>
<?php endif;?>
	
	<strong>
	  <?php echo $dc_report_relation->getJoinTypeString() ?> 
	  JOIN 
	</strong>
	<em>
	<?php echo $dc_report_relation->getTableRight() ?>
	</em>
	<br />
	<strong>
	  ON
	</strong>
	<em>
	<?php echo $dc_report_relation->getColumnLeftString() ?>
	<strong>
	=
	</strong>
	<?php echo $dc_report_relation->getColumnRightString() ?>
	</em>
	<br />
</td>

