<?php

class dcReportQuery extends BasedcReportQuery
{

  public function __toString()
  {
    return $this->getName();
  }
	
  public function canBePublished()
  {
    return 
      (count($this->getdcReportTables())>0) 
      &&
      (count($this->getdcReportFields())>0);
  }
  

	public function getCriteria()
	{
                $dbMap = dcPropelReflector::getDatabaseMap($this->getDatabase());
		$c = new Criteria();
		$c->setDbName($this->getDatabase());
		$this->addSelectColumns($c);
		$this->addConditions($c);
		$this->addRelations($c);
		return $c;
	}
	

	public function getDatabaseMap()
	{
		return dcPropelReflector::getDatabaseMap($this->getDatabase());
	}

	protected function addSelectColumns (Criteria $c)
	{
		$columns = $this->getdcReportFields();
		foreach ($columns as $column)
		{
			$column->build($c);
			
		}
	}
	
	protected function addRelations (Criteria &$c)
	{
	    $tables = $this->getdcReportTables();
	    $t=$this->getFirstTable();
	    if (!is_null($t))
	    { 
		$c->setPrimaryTableName($t->getPropelName());
	    }
		foreach ($tables as $table)
		{
		      if (strcmp($table->getAlias(),$table->getPropelName())!=0)
		      {
			$c->addAlias($table->getAlias(),$table->getPropelName());
		      }
		}
		$relations = $this->getdcReportRelations();
		foreach($relations as $relation)
		{
			$relation->build($c);
		}
	}
	
	protected function addConditions (Criteria $c)
	{
		$groups = $this->getdcReportGroupCriterias();
		foreach ($groups as $group)
		{
			$crit_or = $group->build($c);
			if(isset($criterion))
				$criterion->addOr($crit_or);
			else
				$criterion = $crit_or;
		}
		if(isset($criterion))
			$c->add($criterion);
		
	}
	
	public function getSql()
	{
    $params=array();
    $ret= BasePeer::createSelectSql($this->getCriteria(),$params);
    foreach($params as $key=>$p){
      $i=$key+1;
      $ret=str_replace(":p$i",'"'.$p['value'].'"',$ret);
    }

   return $ret;
	}

  public function getDefaultSort()
  {
    $field=current($this->getdcReportFields());
    $col=null;
    if (!is_null($field))
    {
      $col=$field->getId();
    }
    return array($col,null);
  }
  
  public function getFirstTable()
  {
  	$cri = new Criteria();
  	$cri->add(dcReportTablePeer::DC_REPORT_QUERY_ID, $this->getId());
  	$cri->addAscendingOrderByColumn(dcReportTablePeer::ID);
  	return dcReportTablePeer::doSelectOne($cri);
  }
  
	public function getLastTable()
  {
  	$cri = new Criteria();
  	$cri->add(dcReportTablePeer::DC_REPORT_QUERY_ID, $this->getId());
  	$cri->addDescendingOrderByColumn(dcReportTablePeer::ID);
  	return dcReportTablePeer::doSelectOne($cri);
  }

  public function getdcReportTables($cri= null, PropelPDO $con = null)
  {
  	if(is_null($cri)) $cri = new Criteria();
  	$cri->add(dcReportTablePeer::DC_REPORT_QUERY_ID, $this->getId());
  	$cri->addAscendingOrderByColumn(dcReportTablePeer::ID);
  	return dcReportTablePeer::doSelect($cri);
  }
 

  public function getNameSlug()
  {
    // replace all non letters or digits by -
    $text = preg_replace('/\W+/', '-', $this->getName());
 
    // trim and lowercase
    $text = strtolower(trim($text, '-'));
 
    return $text;

  }
  
  
}
