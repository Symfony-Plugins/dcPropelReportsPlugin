<?php

/**
 * dcReportFilter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class dcReportFilterForm extends BasedcReportFilterForm
{
  public function configure()
  {
    if ( isset($this['created_at']) ) unset($this['created_at']);
    if ( isset($this['updated_at']) ) unset($this['updated_at']);
 	$this->setWidget('dc_report_query_id',new sfWidgetFormInputHidden());
	$this->setWidget('filter_type',new sfWidgetFormChoice(array(
	    	'choices'=>dcReportFilter::getFilterTypes()
	    )));

	sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));

	$this->getWidget('filter_type')->setAttribute('onchange',
      strtr("new Ajax.Updater('%id_to_update%','%url%',
            {
                parameters: %params% 
            })",
        array(
		        '%url%'           => url_for('dc_report_filter/typeChange?dc_report_query_id='.$this->getObject()->getDcReportQueryId()),
		        '%id_to_update%'  => "table_name",
		        '%params%'        => "'type='+$(this).getValue()"
	      )));

	if ( $this->getObject()->getFilterType() != dcReportFilter::FILTER_TYPE_DATABASE_OBJECT )
	{
		$this->setWidget('database_table_name',new sfWidgetFormInputHidden());
	}
	else 
	{
		$this->setWidget('database_table_name',new sfWidgetFormChoice(array(
	         'choices'=> $this->getTables())
	    ));
	}

  $this->getWidget('dc_report_table_id')->setAttribute('onchange',
        strtr("new Ajax.Updater('%id_to_update%','%url%',
            {
                parameters: %params% 
            })",
            array(
                '%url%'           => url_for('dc_report_filter/tableChange?dc_report_query_id='.$this->getObject()->getDcReportQueryId()),
                '%id_to_update%'  => "column",
                '%params%'        => "'table='+$(this).getValue()"
            )));

        $this->setWidget('column',new sfWidgetFormChoice(array(
          'choices'=>self::getColumns($this->getObject()->getDcReportTable())
        )));

	$this->setValidator('filter_type',new sfValidatorChoice(array(
		'choices'=>array_keys(dcReportFilter::getFilterTypes()),
	)));

  }

  public static function getColumns($table)
  {
    if ( empty($table) ) return array();
    $ret=array();
    foreach($table->getColumns() as $col)
    {
      $ret[$col->getColumnName()]=$col->getColumnName();
    }
    asort($ret);
    return $ret;
  }


  protected function getTables()
  {
    $ret=array();
    foreach(dcPropelReflector::getTableMaps($this->getConnectionName()) as $tmap)
    {
      if (!preg_match('/^dc_report_/',$tmap->getName()))
      {
        $ret[$tmap->getName()]=$tmap->getName();
      }
    } 
    asort($ret);
    return $ret;
  }

  protected function getConnectionName()
  {
    return $this->getObject()->getDcReportQuery()->getDatabase();
  }
  
  public function getJavaScripts()
  {
    return array_merge(
      parent::getJavaScripts(),
      array('/dcPropelReportsPlugin/js/prototype.js')
    );
  }

}
