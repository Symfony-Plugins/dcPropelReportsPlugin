<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * dcReportFilter filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasedcReportFilterFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'dc_report_query_id'  => new sfWidgetFormPropelChoice(array('model' => 'dcReportQuery', 'add_empty' => true)),
      'dc_report_field_id'  => new sfWidgetFormPropelChoice(array('model' => 'dcReportField', 'add_empty' => true)),
      'name'                => new sfWidgetFormFilterInput(),
      'filter_type'         => new sfWidgetFormFilterInput(),
      'database_table_name' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'dc_report_query_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportQuery', 'column' => 'id')),
      'dc_report_field_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportField', 'column' => 'id')),
      'name'                => new sfValidatorPass(array('required' => false)),
      'filter_type'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'database_table_name' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dc_report_filter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'dcReportFilter';
  }

  public function getFields()
  {
    return array(
      'dc_report_query_id'  => 'ForeignKey',
      'dc_report_field_id'  => 'ForeignKey',
      'name'                => 'Text',
      'filter_type'         => 'Number',
      'database_table_name' => 'Text',
      'id'                  => 'Number',
    );
  }
}
