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
 	$this->setWidget('dc_report_query_id',new sfWidgetFormInputHidden());
	$this->setWidget('filter_type',new sfWidgetFormChoice(array(
	    	'choices'=>dcReportFilter::getFilterTypes()
	    )));

	sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url','Javascript'));

	$this->getWidget('filter_type')->setAttribute('onchange',
		remote_function(array(
		'url'=>'dc_report_filter/typeChange?dc_report_query_id='.$this->getObject()->getDcReportQueryId(),
		'update'   => "table_name",
		'with'=>"'type='+$(this).getValue()"
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

	$criteria=new Criteria();
	$criteria->add(dcReportFieldPeer::DC_REPORT_QUERY_ID, $this->getObject()->getDcReportQueryId());

	$this->setWidget('dc_report_field_id', 
			 new sfWidgetFormPropelChoice(array('model'=>'dcReportField','criteria'=>$criteria
                                                     ) 
                                                )
                         );

	$this->setValidator('filter_type',new sfValidatorChoice(array(
		'choices'=>array_keys(dcReportFilter::getFilterTypes()),
	)));

	$this->setValidator('dc_report_field_id',new sfValidatorPropelChoice(array(
		'model'=>'dcReportField','criteria'=>$criteria
	),array('invalid'=>'Field not valid')));
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

}
