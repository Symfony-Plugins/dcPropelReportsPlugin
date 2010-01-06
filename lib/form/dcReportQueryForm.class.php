<?php

/**
 * dcReportQuery form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class dcReportQueryForm extends BasedcReportQueryForm
{
  public function configure()
  {
    unset($this['is_published']);
    $this->setWidget('database',new sfWidgetFormChoice(array(
      'choices'=>$this->getConnectionNames()
    )));
    $this->widgetSchema->setLabel('database','Datasource name');
  }

  public function getConnectionNames()
  {
    $ret=array();
    foreach (dcPropelReflector::getDatabaseConnections() as  $dc)
    {
      $name=$dc->getParameter('name');
      if (!array_key_exists($name,$ret))
      {
        $ret[$name]=$name;
      }
    }
    return $ret;
  }
}
