<?php

/**
 * dc_report_field module configuration.
 *
 * @package    prueba
 * @subpackage dc_report_field
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_report_fieldGeneratorConfiguration extends BaseDc_report_fieldGeneratorConfiguration
{

  public function getForm($object = null)
  {
    if (is_null($object))
    {
      $object=new dcReportField();
    }
    $object->setDcReportQueryId(sfContext::getInstance()->getUser()->getAttribute('dc_report_query/current_report'));
    return parent::getForm($object);
  }
  
}
