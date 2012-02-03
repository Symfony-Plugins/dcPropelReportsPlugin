<?php

/**
 * dc_report_filter module configuration.
 *
 * @package    prototype
 * @subpackage dc_report_filter
 * @author     ncuesta
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_report_filterGeneratorConfiguration extends BaseDc_report_filterGeneratorConfiguration
{


  public function getForm($object = null, $options = array())
  {
    if (is_null($object))
    {
      $object=new dcReportFilter();
    }
    $object->setDcReportQueryId(sfContext::getInstance()->getUser()->getAttribute('dc_report_query/current_report'));
    return parent::getForm($object, $options);
  }


}
