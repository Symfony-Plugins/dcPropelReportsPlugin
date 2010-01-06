<?php

class dcReportGroupCriteria extends BasedcReportGroupCriteria
{

  public function getNewReportCriteria()
  {
    $ret=new dcReportCriteria();
    $ret->setdcReportGroupCriteriaId($this->getId());
    $ret->setdcReportQueryId($this->getdcReportQueryId());
    return $ret;
  }

	public function build(Criteria $c)
	{
		$criterias = $this->getdcReportCriterias();
		foreach ($criterias as $criteria)
		{
			$crit_and = $criteria->build($c);
			if(isset($criterion))
				$criterion->addAnd($crit_and);
			else
				$criterion = $crit_and;
		}
		return isset($criterion)?$criterion:null;
	}
}
