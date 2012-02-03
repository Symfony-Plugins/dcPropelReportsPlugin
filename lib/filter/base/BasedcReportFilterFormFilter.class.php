<?php

/**
 * dcReportFilter filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasedcReportFilterFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'dc_report_query_id'  => new sfWidgetFormPropelChoice(array('model' => 'dcReportQuery', 'add_empty' => true)),
      'dc_report_table_id'  => new sfWidgetFormPropelChoice(array('model' => 'dcReportTable', 'add_empty' => true)),
      'column'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'filter_type'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'database_table_name' => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'dc_report_query_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportQuery', 'column' => 'id')),
      'dc_report_table_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportTable', 'column' => 'id')),
      'column'              => new sfValidatorPass(array('required' => false)),
      'name'                => new sfValidatorPass(array('required' => false)),
      'filter_type'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'database_table_name' => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
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
      'dc_report_table_id'  => 'ForeignKey',
      'column'              => 'Text',
      'name'                => 'Text',
      'filter_type'         => 'Number',
      'database_table_name' => 'Text',
      'id'                  => 'Number',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
