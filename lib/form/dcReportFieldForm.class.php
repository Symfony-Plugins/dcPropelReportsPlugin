<?php

/**
 * dcReportField form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class dcReportFieldForm extends BasedcReportFieldForm
{
  public function configure()
  {
    if ( isset($this['created_at']) ) unset($this['created_at']);
    if ( isset($this['updated_at']) ) unset($this['updated_at']);
  		sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
  		 
  		$this->setWidget('dc_report_query_id',new sfWidgetFormInputHidden());
      $this->getWidget('dc_report_table_id')->setAttribute('onchange', 
        strtr("new Ajax.Updater('%id_to_update%','%url%',
            {
                parameters: %params% 
            })",
            array(
                '%url%'           => url_for('dc_report_field/tableChange?dc_report_query_id='.$this->getObject()->getDcReportQueryId()),
                '%id_to_update%'  => "column",
                '%params%'        => "'table='+$(this).getValue()"
            )));
	    
	    if (is_null($this->getObject()->getDcReportTableId()))
	    {
	    	$this->setWidget('column',new sfWidgetFormInput());
	    }
	    else 
	    {
	    	$this->setWidget('column',new sfWidgetFormChoice(array(
		      'choices'=>self::getColumns($this->getObject()->getDcReportTable())
		    )));
	    }
    
	    $criteria=new Criteria();
	    $criteria->add(dcReportTablePeer::DC_REPORT_QUERY_ID, $this->getObject()->getDcReportQueryId());
	    $criteria->addAscendingOrderByColumn(dcReportTablePeer::PROPEL_NAME);
	    $this->getWidget('dc_report_table_id')->addOption('criteria',$criteria);


	    $this->setWidget('handler',new sfWidgetFormChoice(array(
	    	'choices'=>dcReportField::getHandlerTypes()
	    )));


	      $this->setValidator('handler',new sfValidatorChoice(array(
		'choices'=>array_keys(dcReportField::getHandlerTypes()),
	      )));
	    
	    $this->getValidatorSchema()->setPostValidator(new sfValidatorCallback(array(
	          'callback' => array($this,'checkAlias'),
	        ))
	    );
  }
  

  public static function getColumns($table)
  {
    $ret=array();
    foreach($table->getColumns() as $col)
    {
      $ret[$col->getColumnName()]=$col->getColumnName();
    }
    asort($ret);
    return $ret;
  }
  
  public function checkAlias($validator,$values)
  {
    if (is_null($values['dc_report_table_id']) || empty($values['dc_report_table_id']) || ($values['handler'] != dcReportField::HANDLER_NONE))
    {
    	$valid = new sfValidatorString(array('max_length' => 255, 'required' => true),array('required'=>"If you don't select a table or use a handler you must select an alias "));
    	$valid->clean($values['alias']);
    }	
  	
    $values['alias'] = trim($values['alias']);
    if (!is_null($values['alias']) && !empty($values['alias']))
    {
	$valid = new sfValidatorRegex(array('pattern'=>'/^(\w)+$/'),array('invalid'=>'An alias must be only one word'));
        $valid->clean($values['alias']);
    }

    if (!is_null($values['alias']) && !empty($values['alias']))
    {

    	$valid= new sfValidatorPropelUnique(
          array(
            'model'=>'dcReportField',
            'column'=>array('alias','dc_report_query_id'),
          ),
          array(
            'invalid' => "Alias is already in use"
          )
        );
        $valid->clean($values);
    }

    return $values;
  }
  
  public function getJavaScripts()
  {
    return array_merge(
      parent::getJavaScripts(),
      array('/dcPropelReportsPlugin/js/prototype.js')
    );
  }
} 
