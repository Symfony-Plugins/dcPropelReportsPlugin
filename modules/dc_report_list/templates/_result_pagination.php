<div class="sf_admin_pagination">
  <?php echo link_to(image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/first.png', array('alt' => __('First page', array(), 'sf_admin'), 'title' => __('First page', array(), 'sf_admin'))),'dc_report_list/index?page=1') ?>

  <?php echo link_to(image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/previous.png', array('alt' => __('Previous page', array(), 'sf_admin'), 'title' => __('Previous page', array(), 'sf_admin'))),'dc_report_list/index?page='.$pager->getPreviousPage()) ?>

  <?php foreach ($pager->getLinks() as $page): ?>
    <?php if ($page == $pager->getPage()): ?>
      <?php echo $page ?>
    <?php else: ?>
      <?php echo link_to($page,"dc_report_list/index?page=$page")?>
    <?php endif; ?>
  <?php endforeach; ?>

  <?php echo link_to(image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/next.png', array('alt' => __('Next page', array(), 'sf_admin'), 'title' => __('Next page', array(), 'sf_admin'))),'dc_report_list/index?page='.$pager->getNextPage())?>

  <?php echo link_to(image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/last.png', array('alt' => __('Last page', array(), 'sf_admin'), 'title' => __('Last page', array(), 'sf_admin'))),'dc_report_list/index?page='.$pager->getLastPage())?>
</div>
