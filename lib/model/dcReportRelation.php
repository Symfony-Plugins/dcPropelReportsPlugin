<?php

class dcReportRelation extends BasedcReportRelation
{
	
	const JOIN_TYPE_INNER   = 0;
	const JOIN_TYPE_LEFT    = 1;
	const JOIN_TYPE_RIGHT   = 2;
	
  public static function getJoinTypes()
  {
    return array(
	    self::JOIN_TYPE_INNER   =>'INNER',
	    self::JOIN_TYPE_LEFT    =>'LEFT',
	    self::JOIN_TYPE_RIGHT   =>'RIGHT',
    );
  }

  public function getJoinTypeString()
  {
    $joins=self::getJoinTypes();
    if (array_key_exists($this->getJoinType(),$joins))
    {
      return $joins[$this->getJoinType()];
    }
    return '';
  }

	public function build(Criteria $c)
	{
				
		$column_left  = $this->getColumnLeftString();
		$column_right = $this->getColumnRightString();                         
		$c->addJoin($column_left,$column_right,$this->getJoin());
	}

  public function getColumnRightString()
  {
		$database_name = $this->getdcReportQuery()->getDatabase();
    return dcPropelReflector::buildColumn( $this->getdcReportTableRelatedByDcReportTableRight()->getPropelName(), 
                                           $this->getColumnRight(),
                                           $database_name,
                                           $this->getdcReportTableRelatedByDcReportTableRight()->getAlias());	
  }

  public function getColumnLeftString()
  {
		$database_name = $this->getdcReportQuery()->getDatabase();
    return dcPropelReflector::buildColumn( $this->getdcReportTableRelatedByDcReportTableLeft()->getPropelName(), 
                                           $this->getColumnLeft(),
                                           $database_name,
                                           $this->getdcReportTableRelatedByDcReportTableLeft()->getAlias());  
  }
	
	protected function getJoin()
	{
		switch($this->getJoinType())
		{
			case dcReportRelation::JOIN_TYPE_INNER:
				 return Criteria::INNER_JOIN;
			case dcReportRelation::JOIN_TYPE_LEFT:
				return Criteria::LEFT_JOIN;
			case dcReportRelation::JOIN_TYPE_RIGHT:
				return Criteria::RIGHT_JOIN;
			default:
				throw new Exception('Join Type Not Suported');
		}
	}

  public function getTableLeft()
  {
    return $this->getdcReportTableRelatedByDcReportTableLeft();
  }

  public function getTableRight()
  {
    return $this->getdcReportTableRelatedByDcReportTableRight();
  }
}
