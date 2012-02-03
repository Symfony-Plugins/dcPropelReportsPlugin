<?php

class dcReportField extends BasedcReportField
{
	const HANDLER_NONE   = 0;
	const HANDLER_MAX    = 1;
	const HANDLER_SUM    = 2;
	const HANDLER_COUNT  = 3;
	const HANDLER_MIN    = 4;
	const HANDLER_AVG    = 5;
	const HANDLER_STD    = 6;
	
	
	public static function getHandlerTypes()
	{
		return array(
			self::HANDLER_NONE => 'No Handler',
			self::HANDLER_MAX  => 'MAX',
			self::HANDLER_SUM  => 'SUM',
			self::HANDLER_COUNT=> 'COUNT',
			self::HANDLER_MIN  => 'MIN',
			self::HANDLER_AVG  => 'AVG',
			self::HANDLER_STD  => 'STD',
		);
	}
	
	
	
	public function build(Criteria $c)
	{
		$database_name = $this->getDcReportQuery()->getDatabase();
		$propel_name = $this->getRealColumnName($database_name);
		$propel_name = $this->addHandler($propel_name);
		$alias = $this->getAlias();
		if (!empty($alias))
    	{
			$propel_name .= " AS $alias";
    	}
		
		$c->addSelectColumn($propel_name);
		if ($this->getGroupSelector())
			$c->addGroupByColumn((!empty($alias)&&!is_null($alias))?$alias:$this->getRealColumnName($database_name));
	}
	
	public function getRealColumnName($database_name = 'propel')
	{
		if (is_null($table = $this->getdcReportTable()))
			return $this->getColumn();
		else {	
			$table_name = $table->getPropelName();
			$column_name = $this->getColumn();
			$alias = $this->getDcReportTable()->getAlias();
			return dcPropelReflector::buildColumn( $table_name, $column_name,$database_name,$alias);
		}
	}

	public function getColumnNameForCriteria()
        {
		if($this->hasHandler()){		
			if(!is_null($alias=$this->getAlias()) && !empty($alias))return $alias;
		}
		return $this->getRealColumnName($this->getDcReportQuery()->getDatabase());	 
	}


	public function __toString()
	{
		if(!is_null($show=$this->getShowName()) && !empty($show))return $show;    
		if(!is_null($alias=$this->getAlias()) && !empty($alias))return $alias;
		return $this->getRealColumnName($this->getDcReportQuery()->getDatabase());
	}
	
	public function getColumnNameAsHTML()
	{
		$ret = $this->addHandler($this->getRealColumnName($this->getDcReportQuery()->getDatabase()));
		if (!is_null($alias = $this->getAlias()) && (!empty($alias)))
			$ret .= " <strong>as</strong> ".$alias;
		
		if ($this->getGroupSelector())
			$ret .= "  <strong> [GROUP BY THIS COLUMN]</strong>";
		return $ret;
	}
	

	
	protected function addHandler($propel_name)
	{
		switch($this->getHandler())
		{
			case dcReportField::HANDLER_NONE:
				 return $propel_name;
			case dcReportField::HANDLER_MAX:
				return "MAX($propel_name)";
			case dcReportField::HANDLER_SUM:
				return "SUM($propel_name)";
			case dcReportField::HANDLER_COUNT:
				return "COUNT($propel_name)"; 
			case dcReportField::HANDLER_MIN:
				return "MIN($propel_name)";
			case dcReportField::HANDLER_AVG:
				return "AVG($propel_name)";
			case dcReportField::HANDLER_STD:
				return "STD($propel_name)";
			default:
				throw new Exception('Handlet not defined');
		}
		
	}

  public function getHandlerName()
  {
    $h = self::getHandlerTypes();
    return $h[$this->getHandler()];
  }
	
	public function hasHandler()
	{
		return ($this->getHandler() != dcReportField::HANDLER_NONE);
	}

}
