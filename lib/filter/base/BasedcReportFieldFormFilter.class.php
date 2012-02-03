<?php

/**
 * dcReportField filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasedcReportFieldFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'dc_report_table_id' => new sfWidgetFormPropelChoice(array('model' => 'dcReportTable', 'add_empty' => true)),
      'column'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'alias'              => new sfWidgetFormFilterInput(),
      'group_selector'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'handler'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dc_report_query_id' => new sfWidgetFormPropelChoice(array('model' => 'dcReportQuery', 'add_empty' => true)),
      'show_name'          => new sfWidgetFormFilterInput(),
      'display_in_results' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'column_position'    => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'dc_report_table_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportTable', 'column' => 'id')),
      'column'             => new sfValidatorPass(array('required' => false)),
      'alias'              => new sfValidatorPass(array('required' => false)),
      'group_selector'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'handler'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'dc_report_query_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportQuery', 'column' => 'id')),
      'show_name'          => new sfValidatorPass(array('required' => false)),
      'display_in_results' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'column_position'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('dc_report_field_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'dcReportField';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'dc_report_table_id' => 'ForeignKey',
      'column'             => 'Text',
      'alias'              => 'Text',
      'group_selector'     => 'Boolean',
      'handler'            => 'Number',
      'dc_report_query_id' => 'ForeignKey',
      'show_name'          => 'Text',
      'display_in_results' => 'Boolean',
      'column_position'    => 'Number',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
