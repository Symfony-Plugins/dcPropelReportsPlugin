<?php use_helper('Tag'); ?>

<div class="download_excel"> 
<h3><?php echo image_tag('/dcPropelReportsPlugin/images/excel.png').' '.__('Get result in xls format')?> </h3>

<form action="<?php echo url_for('@dc_report_list_excel?name='.$dc_report_query->getName()) ?>" method="post">

<?php echo __('Page')?>
<?php $select = new sfWidgetFormChoice(array('choices'=> range(1,$pager->getLastPage()))); echo $select->render('export_page') ?>
<?php echo __('containing %rows rows' , array('%rows'=>$pager->getMaxPerPage()), 'messages') ?>

<input type="submit" value="<?php echo __('Export', array(), 'messages') ?>" />
</form>

</div>
