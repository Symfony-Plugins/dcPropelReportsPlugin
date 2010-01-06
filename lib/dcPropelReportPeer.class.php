<?php 
/**
 * dcPropelReportPeer. Generic report static access object
 *
 * This class is responsible for accessing database and retrieving rows of
 * data from reports without trying to do any Object mapping because at this 
 * stage is useless.
 *
 * @author Lic. Christian A. Rodriguez <car@cespi.unlp.edu.ar>
 */

class dcPropelReportPeer
{
  
  public static function doSelect(Criteria $criteria, $name = 'propel')
  {
    $con = Propel::getConnection($criteria->getDbName(), Propel::CONNECTION_READ);

    $stmt=BasePeer::doSelect($criteria, $con);
    $result=array();
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
      $result[] = $row;
    }
    $stmt->closeCursor();
    return $result;
  }

  public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
  {
    if ($con === null) {

      $con = Propel::getConnection($criteria->getDbName(), Propel::CONNECTION_READ);
    }

    $criteria = clone $criteria;
    $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
    $stmt = BasePeer::doCount($criteria, $con);

    if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
      $count = (int) $row[0];
    } else {
      $count = 0; // no rows returned; we infer that means 0 matches.
    }
    $stmt->closeCursor();
    return $count;
  }


}
