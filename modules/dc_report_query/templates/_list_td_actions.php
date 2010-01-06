<td>
  <ul class="sf_admin_td_actions">
    <?php if (!$dc_report_query->getIsPublished()): ?>
      <li class="sf_admin_action_tables">
        <?php echo link_to(__('Tables & relations', array(), 'messages'), 'dc_report_query/tables?id='.$dc_report_query->getId(), array()) ?>
      </li>
      <li class="sf_admin_action_columns">
        <?php echo link_to(__('Columns', array(), 'messages'), 'dc_report_query/columns?id='.$dc_report_query->getId(), array()) ?>
      </li>
      <li class="sf_admin_action_conditions">
        <?php echo link_to(__('Conditions', array(), 'messages'), 'dc_report_query/conditions?id='.$dc_report_query->getId(), array()) ?>
      </li>

      <li class="sf_admin_action_filters">
        <?php echo link_to(__('Filters', array(), 'messages'), 'dc_report_query/filters?id='.$dc_report_query->getId(), array()) ?>
      </li>


      <?php if ($dc_report_query->canBePublished()): ?>
        <li class="sf_admin_action_publish">
          <?php echo link_to(__('Publish', array(), 'messages'), 'dc_report_query/publish?id='.$dc_report_query->getId(), array()) ?>
        </li>
      <?php endif ?>

    <?php else: ?>
      <li class="sf_admin_action_unpublish">
        <?php echo link_to(__('Unpublish', array(), 'messages'), 'dc_report_query/unpublish?id='.$dc_report_query->getId(), array()) ?>
      </li>
      <li class="sf_admin_action_test">
        <?php echo link_to(__('Test', array(), 'messages'), 'dc_report_query/test?id='.$dc_report_query->getId(), array()) ?>
      </li>
    <?php endif ?>
    <li class="sf_admin_action_show">
      <?php echo link_to(__('SQL', array(), 'messages'), '@dc_report_query_show?id='.$dc_report_query->getId(), array()) ?>
    </li>
    <?php echo $helper->linkToEdit($dc_report_query, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($dc_report_query, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
