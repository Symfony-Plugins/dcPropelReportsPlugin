<?php

class dcReportCriteria extends BasedcReportCriteria
{
    const OPERATION_EQUAL         = 0;
    const OPERATION_NOT_EQUAL     = 1;
    const OPERATION_GREATER_THAN  = 2;
    const OPERATION_LESS_THAN     = 3;
    const OPERATION_GREATER_EQUAL = 4;
    const OPERATION_LESS_EQUAL    = 5;
    const OPERATION_LIKE          = 6;
    const OPERATION_NOT_LIKE      = 7;
    const OPERATION_CUSTOM        = 8;
    const OPERATION_ISNULL        = 9;
    const OPERATION_ISNOTNULL     = 10;
    const OPERATION_IN            = 11;
    const OPERATION_NOTIN         = 12;
    
  static $codes=array(
    self::OPERATION_EQUAL         =>  '=',
    self::OPERATION_NOT_EQUAL     =>  '<>',
    self::OPERATION_GREATER_THAN  =>  '>',
    self::OPERATION_LESS_THAN     =>  '<',
    self::OPERATION_GREATER_EQUAL =>  '>=',
    self::OPERATION_LESS_EQUAL    =>  '<=',
    self::OPERATION_LIKE          =>  'LIKE',
    self::OPERATION_NOT_LIKE      =>  'NOT LIKE', 
    self::OPERATION_CUSTOM        =>  'CUSTOM',
    self::OPERATION_ISNULL        =>  'IS NULL',
    self::OPERATION_ISNOTNULL     =>  'IS NOT NULL',
    self::OPERATION_IN            =>  'IN',
    self::OPERATION_NOTIN         =>  'NOT IN',
  );

  private $dc_report_query_id=null;

  public static function getOperationString($code)
  {
    if (array_key_exists($code,self::$codes))
    {
      return self::$codes[$code];
    }
    return '';
  }

  public function setdcReportQueryId($id)
  {
    $this->dc_report_query_id=$id;
  }

  public function getdcReportQueryId()
  {
    return $this->dc_report_query_id;
  }

  public function __toString()
  {
    return $this->getRealColumnName().' '.self::getOperationString($this->getOperation()).' '.$this->getValue();
  }

	public function build(Criteria $c)
	{
		$column = $this->getRealColumnName();
		return $c->getNewCriterion($column,$this->buildValue(),$this->buildOperation());
	}
	
	public function getRealColumnName()
	{
    if (!is_null($this->getdcReportGroupCriteria()))
    {
		  $database_name  = $this->getdcReportGroupCriteria()->getdcReportQuery()->getDatabase();	
    }
    else
    {
      $rquery=dcReportQueryPeer::retrieveByPk($this->getdcReportQueryId());
		  $database_name  = $rquery->getDatabase();	
    }
		$table_name = $this->getDcReportTable()->getPropelName();
		$column_name = $this->getColumn();
		$alias = $this->getDcReportTable()->getAlias();
		return dcPropelReflector::buildColumn( $table_name, $column_name,$database_name,$alias);
	}
	
	protected function buildOperation()
	{
		switch($this->getOperation())
		{
			case dcReportCriteria::OPERATION_EQUAL:
				 return Criteria::EQUAL;
			case dcReportCriteria::OPERATION_NOT_EQUAL:
				 return Criteria::NOT_EQUAL;
			case dcReportCriteria::OPERATION_GREATER_THAN:
				 return Criteria::GREATER_THAN;
			case dcReportCriteria::OPERATION_LESS_THAN:
				 return Criteria::LESS_THAN;
			case dcReportCriteria::OPERATION_GREATER_EQUAL:
				 return Criteria::GREATER_EQUAL;
			case dcReportCriteria::OPERATION_LESS_EQUAL:
				 return Criteria::LESS_EQUAL;
			case dcReportCriteria::OPERATION_LIKE:
				 return Criteria::LIKE;
			case dcReportCriteria::OPERATION_NOT_LIKE:
				 return Criteria::NOT_LIKE;
			case dcReportCriteria::OPERATION_CUSTOM:
				 return Criteria::CUSTOM;
			case dcReportCriteria::OPERATION_ISNULL:
				 return Criteria::ISNULL;
			case dcReportCriteria::OPERATION_ISNOTNULL:
				 return Criteria::ISNOTNULL;
			case dcReportCriteria::OPERATION_IN:
				 return Criteria::IN;
			case dcReportCriteria::OPERATION_NOTIN:
				 return Criteria::NOTIN;
   		default:
				throw new Exception('Operation not defined');
		}

		
	}
	
	protected function buildValue()
	{
		if (($this->getOperation() == dcReportCriteria::OPERATION_IN ) || ($this->getOperation() == dcReportCriteria::OPERATION_NOTIN))
			return dcReportCriteria::buildArrayForString($this->getValue());
		else 
			return $this->getValue(); 
	}
	
	public static function buildArrayForString($str)
	{
		$params = explode(',', preg_replace(array('/^\(/', '/\)$/', '/\s/'), '', $str));
		return $params;
	}

}
