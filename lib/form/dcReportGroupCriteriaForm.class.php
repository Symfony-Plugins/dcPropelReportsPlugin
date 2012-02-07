<?php

/**
 * dcReportGroupCriteria form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class dcReportGroupCriteriaForm extends BasedcReportGroupCriteriaForm
{
  public function configure()
  {
    if ( isset($this['created_at']) ) unset($this['created_at']);
    if ( isset($this['updated_at']) ) unset($this['updated_at']);
  }
  
  public function getJavaScripts()
  {
    return array_merge(
      parent::getJavaScripts(),
      array('/dcPropelReportsPlugin/js/prototype.js')
    );
  }
}
