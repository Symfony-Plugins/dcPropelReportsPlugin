<?php

class dcReportFilter extends BasedcReportFilter
{
	const FILTER_TYPE_STRING          = 0;
	const FILTER_TYPE_DATE_RANGE      = 1;
	const FILTER_TYPE_DATABASE_OBJECT = 2;
	const FILTER_TYPE_NUMBER_RANGE    = 3;
	
	
	public static function getFilterTypes()
	{
		return array(
			self::FILTER_TYPE_STRING           => 'Free Text',
			self::FILTER_TYPE_DATE_RANGE       => 'Date Range',
			self::FILTER_TYPE_DATABASE_OBJECT  => 'Database Object',
			self::FILTER_TYPE_NUMBER_RANGE     => 'Number Range',
		);
	}

	public function getFilterTypeName()
	{
		$types = dcReportFilter::getFilterTypes();
		return $types[$this->getFilterType()];
	}

	public function buildWidget()
	{
		switch($this->getFilterType())
		{
			case dcReportFilter::FILTER_TYPE_STRING :
				 return new sfWidgetFormFilterInput();
			case dcReportFilter::FILTER_TYPE_DATE_RANGE:
        $widget_class=sfConfig::get('app_dc_report_filter_date_widget_class','sfWidgetFormDate');
        $date_options = array("format"=>"%day%/%month%/%year%");
				return new sfWidgetFormFilterDate(array('from_date'=>new $widget_class($date_options), 'to_date'=>new $widget_class($date_options), 'with_empty' => false));
			case dcReportFilter::FILTER_TYPE_DATABASE_OBJECT:
				return new sfWidgetFormPropelChoice(array('model' => dcPropelReflector::getClassNameForTable($this->getDatabaseTableName(),$this->getdcReportQuery()->getDatabase()), 'add_empty' => true));
			case dcReportFilter::FILTER_TYPE_NUMBER_RANGE :
				return new dcWidgetFormFilterNumber(array('from_number' => new sfWidgetFormInput(), 'to_number' => new sfWidgetFormInput(), 'with_empty' => false));
			default:
				throw new Exception('Filter not defined');
		}
	}
	

	public function buildValidator()
	{
		switch($this->getFilterType())
		{
			case dcReportFilter::FILTER_TYPE_STRING :
				 return new sfValidatorPass(array('required' => false));
			case dcReportFilter::FILTER_TYPE_DATE_RANGE:
        $validator_class = sfConfig::get('app_dc_report_filter_date_validator_class','sfValidatorDate');
				return new sfValidatorDateRange(array('required' => false, 'from_date' => new $validator_class(array('required' => false)), 'to_date' => new $validator_class(array('required' => false))));
			case dcReportFilter::FILTER_TYPE_DATABASE_OBJECT:
				return new sfValidatorPropelChoice(array('required' => false, 'model' => dcPropelReflector::getClassNameForTable($this->getDatabaseTableName(),$this->getdcReportQuery()->getDatabase()), 'column' => 'id'));
			case dcReportFilter::FILTER_TYPE_NUMBER_RANGE :
				return new dcValidatorNumberRange(array('required' => false, 'from_number' => new sfValidatorInteger(array('required' => false)), 'to_number' => new sfValidatorInteger(array('required' => false))));
			default:
				throw new Exception('Filter not defined');
		}
	}



	public function getCriterion($criteria, $values)
	{
		switch($this->getFilterType())
		{
			case dcReportFilter::FILTER_TYPE_STRING :
				return $this->getCriterionForTypeString($criteria, $values);
			case dcReportFilter::FILTER_TYPE_DATE_RANGE:
				return $this->getCriterionForTypeDateRange($criteria, $values);
			case dcReportFilter::FILTER_TYPE_DATABASE_OBJECT:
				return $this->getCriterionForTypeDatabaseColumn($criteria, $values);		
			case dcReportFilter::FILTER_TYPE_NUMBER_RANGE :
				return $this->getCriterionForTypeNumberRange($criteria, $values);
			default:
				throw new Exception('Filter not defined');
		}
	}


	protected function getCriterionForTypeString(Criteria $criteria, $values)
	{
	    $colname = $this->getdcReportField();
	    $criterion = null;
	    if (is_array($values) && isset($values['is_empty']) && $values['is_empty'])
	    {
	      $criterion = $criteria->getNewCriterion($colname, '');
	      $criterion->addOr($criteria->getNewCriterion($colname, null, Criteria::ISNULL));
	    }
	    else if (is_array($values) && isset($values['text']) && '' != $values['text'])
	    {      
	      $criterion = $criteria->getNewCriterion($colname, '%'.$values['text'].'%', Criteria::LIKE);
    	    }
		
	    return $criterion;
	}


	  protected function getCriterionForTypeDateRange(Criteria $criteria, $values)
	  {
	    $colname = $this->getdcReportField();
	  
            $criterion = null;
	    if (isset($values['is_empty']) && $values['is_empty'])
	    {
	      $criterion = $criteria->getNewCriterion($colname, null, Criteria::ISNULL);
	    }
	    else
	    {
	      $criterion = null;
	      if (!is_null($values['from']) && !is_null($values['to']))
	      {
		$criterion = $criteria->getNewCriterion($colname, $values['from'], Criteria::GREATER_EQUAL);
		$criterion->addAnd($criteria->getNewCriterion($colname, $values['to'], Criteria::LESS_EQUAL));
	      }
	      else if (!is_null($values['from']))
	      {
		$criterion = $criteria->getNewCriterion($colname, $values['from'], Criteria::GREATER_EQUAL);
	      }
	      else if (!is_null($values['to']))
	      {
		$criterion = $criteria->getNewCriterion($colname, $values['to'], Criteria::LESS_EQUAL);
	      }
	    }
	    return $criterion;
	  }

	   protected function getCriterionForTypeNumberRange(Criteria $criteria, $values)
	  {
	    $colname = $this->getdcReportField();
            $criterion = null;
	    if (isset($values['is_empty']) && $values['is_empty'])
	    {
	      $criterion = $criteria->getNewCriterion($colname, null, Criteria::ISNULL);
	    }
	    else
	    {
	      $criterion = null;
	      if (!is_null($values['from']) && !is_null($values['to']))
	      {
		$criterion = $criteria->getNewCriterion($colname, $values['from'], Criteria::GREATER_EQUAL);
		$criterion->addAnd($criteria->getNewCriterion($colname, $values['to'], Criteria::LESS_EQUAL));
	      }
	      else if (!is_null($values['from']))
	      {
		$criterion = $criteria->getNewCriterion($colname, $values['from'], Criteria::GREATER_EQUAL);
	      }
	      else if (!is_null($values['to']))
	      {
		$criterion = $criteria->getNewCriterion($colname, $values['to'], Criteria::LESS_EQUAL);
	      }
	    }
	    return $criterion;
	  }

	  protected function getCriterionForTypeDatabaseColumn(Criteria $criteria, $value)
	  {
	    $colname = $this->getdcReportField();
      $criterion = null;
	    if (is_array($value))
	    {
	      $values = $value;
	      $value = array_pop($values);
	      $criterion = $criteria->getNewCriterion($colname, $value);
	      foreach ($values as $value)
	      {
      		$criterion->addOr($criteria->getNewCriterion($colname, $value));
	      }
	    }
	    else
	    {
		    $criterion = $criteria->getNewCriterion($colname, $value);	      
	    }
	    return $criterion;
	  }

  private function getdcReportField()
  {
    return $this->getdcReportTable()->getColumn($this->getColumn())->getFullyQualifiedName();
  }

}
