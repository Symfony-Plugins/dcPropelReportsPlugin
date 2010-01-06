<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <table cellspacing="0">
      <thead>
        <tr>
          <?php include_partial('dc_report_list/result_th', array('dc_report_query'=>$dc_report_query,'sort' => $sort)) ?>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="<?php echo count($dc_report_query->getdcReportFields())?>">
            <?php if ($pager->haveToPaginate()): ?>
              <?php include_partial('dc_report_list/result_pagination', array('pager' => $pager)) ?>
            <?php endif; ?>

            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
            <?php endif; ?>
          </th>
        </tr>
      </tfoot>
      <tbody>
        <?php $i=0?>
        <?php foreach ($pager->getResults() as $key => $row): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <tr class="sf_admin_row <?php echo $odd ?>">
            <?php include_partial('dc_report_list/result_row', array('row' => $row)) ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
<?php if (class_exists('sfPhpExcel')): ?>
	<?php include_partial('dc_report_list/export_to_excel', array('dc_report_query' => $dc_report_query,
                              					       'pager'=>$export_pager)) ?>
<?php endif;?>

  <?php endif; ?>
</div>
