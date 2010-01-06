<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="sf_admin_filters">
  <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif; ?>

  <form action="<?php echo url_for('@dc_report_list_filter?name='.$dc_report_query->getName()) ?>" method="post">
    <table cellspacing="0">
      <tfoot>
        <tr>
          <td colspan="2">
            <?php echo $form->renderHiddenFields() ?>
            <?php echo link_to(__('Reset', array(), 'sf_admin'), '@dc_report_list_filter?name='.$dc_report_query->getName().'&_reset=1', array(), array('query_string' => '_reset', 'method' => 'post')) ?>
            <input type="submit" value="<?php echo __('Filter', array(), 'sf_admin') ?>" />
          </td>
        </tr>
      </tfoot>
      <tbody>
        
<?php  foreach ($form as $name => $field): ?>

  <tr class="sf_admin_form_row sf_admin_str sf_admin_filter_field_<?php echo $name; ?>">
    <td>
      <?php echo $form[$name]->renderLabel() ?>
    </td>
    <td>
      <?php echo $form[$name]->renderError() ?>
      <?php echo $form[$name]->render() ?>
    </td>
  </tr>
<?php endforeach; ?>

      </tbody>
    </table>
  </form>
</div>
