<?php

class dcReportTable extends BasedcReportTable
{

  public function __toString()
  {
    return $this->getPropelName().(strcasecmp($this->getPropelName(),$this->getAlias())==0?'':' as '.$this->getAlias());
  }

	public function getClasssName()
	{
		$database_name = $this->getdcReportQuery()->getDatabase();
		return dcPropelReflector::getClassNameForTable($this->getPropelName(), $database_name);
	}

  public function getColumns()
  {
     $tmap=dcPropelReflector::getTableMap($this->getPropelName(),$this->getdcReportQuery()->getDatabase());
      return $tmap->getColumns();
  }

  public function getRelation()
  {
    $rels=$this->getdcReportRelationsRelatedByDcReportTableLeft();
    if (count($rels)==1)
    {
      return array_pop($rels);
    }
    return null;
  }
}
