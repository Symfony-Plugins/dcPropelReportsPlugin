<?php use_helper('Form'); ?>

<?php 
$options = array();
for($i=1; $i<= $pager->getLastPage(); $i ++)
	$options[$i] = $i;
?>

<div class="download_excel"> 
<h1> Export Results to Excel <?php echo image_tag('/dcPropelReportsPlugin/images/excel.png')?> </h1>

<form action="<?php echo url_for('@dc_report_list_excel?name='.$dc_report_query->getName()) ?>" method="post">

<?php echo __('Select a page:' , array(), 'messages') ?>


<?php echo select_tag('export_page', options_for_select($options, 0)) ?>
<?php echo __('with %rows rows or' , array('%rows'=>$pager->getMaxPerPage()), 'messages') ?>
<?php echo checkbox_tag('export_all', 1, false); ?>
<?php echo __('export all:' , array(), 'messages') ?>


 
<input type="submit" value="<?php echo __('Export >>', array(), 'messages') ?>" />
</form>

</div>
