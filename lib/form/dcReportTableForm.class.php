<?php

/**
 * dcReportTable form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class dcReportTableForm extends BasedcReportTableForm
{
  public function configure()
  {
    if ( isset($this['created_at']) ) unset($this['created_at']);
    if ( isset($this['updated_at']) ) unset($this['updated_at']);
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
  	$this->setWidget('dc_report_query_id',new sfWidgetFormInputHidden());

    $this->setWidget('has_alias', new sfWidgetFormInputCheckbox(array(),array(
      'onchange'=>"$(this).checked?$('dc_report_table_alias').enable():$('dc_report_table_alias').disable()")));

    $this->setWidget('propel_name',new sfWidgetFormChoice(array(
      'choices'=>array(''=>'')+$this->getTables()
    )));

    if ($this->isNew())
    {
      $this->setDefault('has_alias',false);
    }
    else
    {
      $this->setDefault('has_alias',strcmp($this->getObject()->getPropelName(),$this->getObject()->getAlias())!=0);
    }

    $this->getWidget('alias')->setAttribute('disabled', true);

    $this->getValidator('alias')->setOption('required',false);
    $this->setValidator('has_alias',new sfValidatorPass());
    

    $this->initializeRelations();

    $this->getValidatorSchema()->setPostValidator(new sfValidatorAnd(
      array(
        new sfValidatorCallback(array(
          'callback' => array($this,'checkAlias'),
        )),
        new sfValidatorPropelUnique(
          array(
            'model'=>'dcReportTable',
            'column'=>array('alias','dc_report_query_id'),
          ),
          array(
            'invalid' => "Alias is already in use. If you don't select has alias, then selected table is in use"
          )
        ),
        new sfValidatorCallback(array(
            'callback' => array($this,'checkColumnRight'),
        )),
        new sfValidatorCallback(array(
          'callback' => array($this,'checkLeftTable'),
        )),
      ))
    );
    

    $this->setWidget('column_right',new sfWidgetFormChoice(array(
      'choices'=>array()
    )));
    $this->setValidator('column_right',new sfValidatorPass());

    $ltable=$this->getLeftTable();
    if (!is_null($ltable))
    {
      $this->getWidget('propel_name')->setAttribute('onchange',
          "new Ajax.Request('". url_for('dc_report_table/getColumnOptionsForTable')."',
            {
                onLoading: function () { 
                    $('dc_report_table_column_right').disable(); 
                },
                onComplete: function (request) { 
                    dc_propel_relation_update_columns_JSON(request,$('dc_report_table_column_right'));$('dc_report_table_column_right').enable();
                },
                parameters: 'table='+$(this).getValue()
            })");
    }
    else
    {
      $this->getWidget('column_right')->setAttribute('disabled',true);
    }

  }

  public function checkColumnRight($validator, $values)
  {
    $ltable=$this->getLeftTable(); 
    if (!empty($ltable)&&!empty($values['propel_name'])&&!array_key_exists($values['column_right'],$this->getColumnsForTable($values['propel_name'])))
    {
      throw new sfValidatorError($validator, 'Column right is invalid');
    }
    return $values;
  }

  public function checkAlias($validator,$values)
  {
    if (!is_null($values['has_alias']) && empty($values['alias']))
    {
      throw new sfValidatorError($validator, 'Alias is required');
    }
    else
    {
      $alias=$values['alias'];
      if (empty($alias))
      {
        $values['alias']=$values['propel_name'];
      }
    }
    return $values;
  }

  public function checkLeftTable($validator,$values)
  {
    $ltable=$this->getLeftTable(); 
    if (is_null($ltable)) return $values;
    
    $table = null;
    $id = $values['dc_report_table_left'];
    if (!is_null($id) && ($id != ""))
    {
	$table = dcReportTablePeer::retrieveByPk($id);
    }

    if (is_null($table))
    {
       throw new sfValidatorError($validator, 'Table left is invalid');
    }
    else
    {
      $valid = new sfValidatorChoice(array(
        'choices'=>array_keys($this->getColumnsForTable($table->getPropelName())),
      ),array('invalid'=>'Left Column is not valid'));
      $valid->clean($values['column_left']);
      
      $valid = new sfValidatorChoice(array(
        'choices'=>array_keys(dcReportRelation::getJoinTypes()),
      ),array('invalid'=>'Join Type is not valid'));
       $valid->clean($values['join_type']);
    } 
    return $values;
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

  protected function initializeRelations()
  {
   
    $this->setWidget('join_type',new sfWidgetFormChoice(array(
    'choices'=>dcReportRelation::getJoinTypes()
    )));
 
    $ltable=$this->getLeftTable(); 
    if (is_null($ltable))
    {
	    $this->setWidget('dc_report_table_left',new sfWidgetFormChoice(array(
	      'choices'=>array()
	    )));
	    $this->setWidget('column_left',new sfWidgetFormChoice(array(
	      'choices'=>array()
	    )));
	    $this->setValidator('dc_report_table_left',new sfValidatorPass());	
	    
            $this->getWidget('dc_report_table_left')->setAttribute('disabled',true);
	    $this->getWidget('column_left')->setAttribute('disabled',true);
	    $this->getWidget('join_type')->setAttribute('disabled',true);
    }

    else {
	    $criteria=new Criteria();
	    $criteria->add(dcReportTablePeer::DC_REPORT_QUERY_ID, $this->getObject()->getDcReportQueryId());
	    $criteria->addAscendingOrderByColumn(dcReportTablePeer::PROPEL_NAME);
	    $this->setWidget('dc_report_table_left', new sfWidgetFormPropelChoice(array('model'=>'dcReportTable', 'criteria'=>$criteria)));

	    $table=$this->getLeftTable();

	    $this->getWidget('dc_report_table_left')->setDefault(!is_null($table)?$table->getId():null);


	    $this->getWidget('dc_report_table_left')->setAttribute('onchange',
          "new Ajax.Request('". url_for('dc_report_table/getColumnOptionsForTable')."',
            {
                onLoading: function () { 
                    $('dc_report_table_column_left').disable(); 
                },
                onComplete: function (request) { 
                    dc_propel_relation_update_columns_JSON(request,$('dc_report_table_column_left'));$('dc_report_table_column_left').enable();
                },
                parameters: 'table='+$(this).getValue()
            })");

    
	    $this->setValidator('dc_report_table_left',new sfValidatorPropelChoice(
		  array(
		    'model'=>'dcReportTable',
		    'criteria' => $criteria,
		  ),
		  array(
		    'invalid' => "Left side table is not valid"
		  )
		)
	     );
	    $this->setWidget('column_left',new sfWidgetFormChoice(array(
	      'choices'=>!is_null($table)?$this->getColumnsForTable($table->getPropelName()):array(),
	    )));
    
   }
        $this->setValidator('join_type',new sfValidatorPass());
	$this->setValidator('column_left',new sfValidatorPass());
  }

  public function getLeftTable()
  {
    $dc_rel=$this->getObject()->getRelation();
    if (is_null($dc_rel))
    {
      $table=dcReportTablePeer::getLast($this->getObject()->getdcReportQuery());
      if (!is_null($table)&&($table->getId()!=$this->getObject()->getId()))
      {
        return $table;
      }
    }
    else
    {
      return $dc_rel->getTableLeft();
    }
    return null; 
  }

  public function getColumnsForTable($table)
  {
    $table_map=dcPropelReflector::getTableMap($table,$this->getConnectionName());
    return dcPropelReflector::getColumnsAsOptions($table_map);
  }

 protected function doSave($con = null)
  {
    $ltable=$this->getLeftTable();
    parent::doSave($con);
    if (!is_null($ltable))
    {
      $rel=new dcReportrelation();
      $rel->setDcReportQuery($this->getObject()->getDcReportQuery());
      $rel->setDcReportTableLeft($this->values['dc_report_table_left']);
      $rel->setDcReportTableRight($this->getObject()->getId());
      $rel->setColumnRight($this->values['column_right']);
      $rel->setColumnLeft($this->values['column_left']);
      $rel->setJoinType($this->values['join_type']);
      $rel->save($con);
    }
  }

  public function getJavaScripts()
  {
    return array_merge(
      parent::getJavaScripts(),
      array('/dcPropelReportsPlugin/js/prototype.js', '/dcPropelReportsPlugin/js/dc_propel_table.js')
    );
  }
}
