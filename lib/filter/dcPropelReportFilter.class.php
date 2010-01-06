<?php


class dcPropelReportFilter extends sfFormFilter 
{

   private $dc_report_query = null;

   public function __construct(dcReportQuery $report = null,$options = array(), $CSRFSecret = null)
   {
	$this->dc_report_query = $report;
	parent::__construct(array(), $options, $CSRFSecret);
   }

   public function setup()
   {
  	    foreach ($this->dc_report_query->getdcReportFilters() as $dc_report_filter)
	    {
		$this->setWidget($dc_report_filter->getId(), $dc_report_filter->buildWidget());
		$this->setValidator($dc_report_filter->getId(), $dc_report_filter->buildValidator());
	        $this->widgetSchema->setLabel($dc_report_filter->getId(), $dc_report_filter->getName());
            }
	    $this->widgetSchema->setNameFormat('dc_report_list_filters[%s]');
	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	    parent::setup();
   }


   public function buildCriteria(array $values, Criteria $criteria = null)
   {
	if (is_null($criteria)) $criteria = new Criteria();
	$criterion = $criteria->getNewCriterion('test', true, Criteria::CUSTOM);
        foreach ($this->dc_report_query->getdcReportFilters() as $dc_report_filter)
	{

		if (isset($values[$dc_report_filter->getId()])) {
			$cri = $dc_report_filter->getCriterion($criteria, $values[$dc_report_filter->getId()]);
			if(is_null($criterion)) 
				$criterion = $cri;
			elseif (!is_null($cri)) 
				if ($dc_report_filter->isComplexFilter())
					$criteria->addHaving($cri);
				else
					$criterion->addAnd($cri);
		}
	}
	if (!is_null($criterion)) 
		$criteria->add($criterion);
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
    );
  }


}
