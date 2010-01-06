<div class="sf_admin_list">
  <?php if (!count($relations)): ?>
  	<?php if (!count($tables)): ?>
    		<p><?php echo __('No result', array(), 'sf_admin') ?></p>
	<?php else: ?>
	    <table cellspacing="0">
	      <thead>
		<tr>
		  <?php include_partial('dc_report_table/list_th_stacked', array('sort'=>null)) ?>
		</tr>
	      </thead>
	      <tbody>
		  <tr class="sf_admin_row odd">
			<td colspan="1"> <?php echo $tables[0]; ?> </td>
		  </tr>
	      </tbody>
	    </table>		
	<?php endif;?>
  <?php else: ?>


    <table cellspacing="0">
      <thead>
        <tr>
          <?php include_partial('dc_report_table/list_th_stacked', array('sort'=>null)) ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($relations as $i => $dc_report_relation): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <tr class="sf_admin_row <?php echo $odd ?>">
            <?php include_partial('dc_report_table/relation', array('dc_report_relation' => $dc_report_relation, 'pri'=>$relations[0])) ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

