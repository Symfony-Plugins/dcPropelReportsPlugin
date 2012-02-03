<?php

/**
 * dcReportRelation filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasedcReportRelationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'dc_report_table_left'  => new sfWidgetFormPropelChoice(array('model' => 'dcReportTable', 'add_empty' => true)),
      'dc_report_table_right' => new sfWidgetFormPropelChoice(array('model' => 'dcReportTable', 'add_empty' => true)),
      'column_right'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'column_left'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'join_type'             => new sfWidgetFormFilterInput(),
      'dc_report_query_id'    => new sfWidgetFormPropelChoice(array('model' => 'dcReportQuery', 'add_empty' => true)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'dc_report_table_left'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportTable', 'column' => 'id')),
      'dc_report_table_right' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportTable', 'column' => 'id')),
      'column_right'          => new sfValidatorPass(array('required' => false)),
      'column_left'           => new sfValidatorPass(array('required' => false)),
      'join_type'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'dc_report_query_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportQuery', 'column' => 'id')),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('dc_report_relation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'dcReportRelation';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'dc_report_table_left'  => 'ForeignKey',
      'dc_report_table_right' => 'ForeignKey',
      'column_right'          => 'Text',
      'column_left'           => 'Text',
      'join_type'             => 'Number',
      'dc_report_query_id'    => 'ForeignKey',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}
