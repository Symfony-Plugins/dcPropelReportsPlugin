<?php
/**
 * dcPropelReportPager. Pager for report results being display
 *
 * This class implements a subclass of abstract sfPager class to allow reports
 * being paginated 
 *
 * @author Lic. Christian A. Rodriguez <car@cespi.unlp.edu.ar>
 */

class dcPropelReportPager extends sfPager
{
  protected
    $criteria = null,
    $results_method_name  = 'doSelect',
    $count_method_name        = 'doCount';

  public function __construct($class, $maxPerPage = 10)
  {
    parent::__construct($class, $maxPerPage);
  }


  public function init()
  {
    $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
    $maxRecordLimit = $this->getMaxRecordLimit();

    $cForCount = clone $this->getCriteria();
    $cForCount->setOffset(0);
    $cForCount->setLimit(0);
 //   $cForCount->clearGroupByColumns();

    $count = call_user_func(array($this->getClass(), $this->getCountMethod()), $cForCount);
    $this->setNbResults($hasMaxRecordLimit ? min($count, $maxRecordLimit) : $count);

    $c = $this->getCriteria();
    $c->setOffset(0);
    $c->setLimit(0);

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));

      $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
      $c->setOffset($offset);

      if ($hasMaxRecordLimit)
      {
        $maxRecordLimit = $maxRecordLimit - $offset;
        if ($maxRecordLimit > $this->getMaxPerPage())
        {
          $c->setLimit($this->getMaxPerPage());
        }
        else
        {
          $c->setLimit($maxRecordLimit);
        }
      }
      else
      {
        $c->setLimit($this->getMaxPerPage());
      }
    }
  }

  public function getResults()
  {
    $c = $this->getCriteria();

    return call_user_func(array($this->getClass(), $this->getResultsMethod()), $c);
  }


  protected function retrieveObject($offset)
  {
    $cForRetrieve = clone $this->getCriteria();
    $cForRetrieve->setOffset($offset - 1);
    $cForRetrieve->setLimit(1);
    $results = call_user_func(array($this->getClass(), $this->getResultsMethod()), $cForRetrieve);
    return is_array($results) && isset($results[0]) ? $results[0] : null;
  }

  public function getResultsMethod()
  {
    return $this->results_method_name;
  }

  public function setResultsMethod($name)
  {
    $this->results_method_name = $name;
  }

  public function getCountMethod()
  {
    return $this->count_method_name;
  }

  public function setCountMethod($name)
  {
    $this->count_method_name = $name;
  }

  public function getCriteria()
  {
    return $this->criteria;
  }

  public function setCriteria($c)
  {
    $this->criteria = $c;
  }

}
