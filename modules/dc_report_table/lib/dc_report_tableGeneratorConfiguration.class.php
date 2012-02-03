<?php

/**
 * dc_report_table module configuration.
 *
 * @package    crPropelreport
 * @subpackage dc_report_table
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_report_tableGeneratorConfiguration extends BaseDc_report_tableGeneratorConfiguration
{
  public function getForm($object = null, $options = array())
  {
    if (is_null($object))
    {
      $object=new dcReportTable();
    }
    $object->setDcReportQueryId(sfContext::getInstance()->getUser()->getAttribute('dc_report_query/current_report'));
    return parent::getForm($object, $options);
  }

}
