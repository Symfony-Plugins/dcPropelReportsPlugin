<?php

/**
 * dcReportCriteria filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasedcReportCriteriaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'dc_report_table_id'          => new sfWidgetFormPropelChoice(array('model' => 'dcReportTable', 'add_empty' => true)),
      'column'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'operation'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'value'                       => new sfWidgetFormFilterInput(),
      'dc_report_group_criteria_id' => new sfWidgetFormPropelChoice(array('model' => 'dcReportGroupCriteria', 'add_empty' => true)),
      'created_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'dc_report_table_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportTable', 'column' => 'id')),
      'column'                      => new sfValidatorPass(array('required' => false)),
      'operation'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'value'                       => new sfValidatorPass(array('required' => false)),
      'dc_report_group_criteria_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'dcReportGroupCriteria', 'column' => 'id')),
      'created_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('dc_report_criteria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'dcReportCriteria';
  }

  public function getFields()
  {
    return array(
      'id'                          => 'Number',
      'dc_report_table_id'          => 'ForeignKey',
      'column'                      => 'Text',
      'operation'                   => 'Number',
      'value'                       => 'Text',
      'dc_report_group_criteria_id' => 'ForeignKey',
      'created_at'                  => 'Date',
      'updated_at'                  => 'Date',
    );
  }
}
