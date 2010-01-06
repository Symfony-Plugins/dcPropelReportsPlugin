<?php

class dcReportTablePeer extends BasedcReportTablePeer
{
  public static function getLast(dcReportQuery $rq,$con=null)
  {
    $c=new Criteria();
    $c->add(self::DC_REPORT_QUERY_ID,$rq->getId());
    $c->addAsColumn('max_date',"MAX(".self::ID.")");
    $stmt=self::doSelectStmt($c,$con);
    $max=null;
    if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
      $max = self::retrieveByPk($row[0]);
    }
    $stmt->closeCursor();
    return $max;
  }
}
