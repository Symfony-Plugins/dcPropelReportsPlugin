<?php

/**
 * dc_report_list actions.
 *
 * @package    crPropelreport
 * @subpackage dc_report_list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class dc_report_listActions extends sfActions
{
    protected function setTestSort($sort)
    {
      if (!is_null($sort[0]) && is_null($sort[1]))
      {
        $sort[1] = 'asc';
      }
      $c=new Criteria();
      $c->add(dcReportFieldPeer::ID,$sort[0]);
      if (count($this->report_query->getdcReportFields($c))>0)
      {
        $this->getUser()->setAttribute('dc_report_list.sort/'.$this->report_query->getName(), $sort);
      }
    }

    protected function getTestSort()
    {
      if (!is_null($sort = $this->getUser()->getAttribute('dc_report_list.sort/'.$this->report_query->getName(), null)))
      {
        return $sort;
      }
      $this->setTestSort($this->report_query->getDefaultSort());
      return $this->getUser()->getAttribute('dc_report_list.sort/'.$this->report_query->getName(), null);
    }

    protected function addTestSortCriteria($criteria)
    {
      if (array(null, null) == ($sort = $this->getTestSort()))
      {
        return;
      }

      $column = dcReportFieldPeer::retrieveByPk($sort[0]);
      if (is_null($column)) return;
      $column=$column->getRealColumnName($this->report_query->getDatabase());
      if ('asc' == $sort[1])
      {
        $criteria->addAscendingOrderByColumn($column);
      }
      else
      {
        $criteria->addDescendingOrderByColumn($column);
      }
    }

    protected function setTestPage($page)
    {
      $this->getUser()->setAttribute('dc_report_list.page/'.$this->report_query->getName(), $page);
    }

    protected function getTestPage()
    {
      return $this->getUser()->getAttribute('dc_report_list.page/'.$this->report_query->getName(), 1 );
    }


  protected function setReportQuery($name)
  {
    $this->getUser()->setAttribute('dc_report_list.query_name',$name);
    $report_query=$this->getReportQuery();
    if (!is_null($report_query))
    {
      $this->getUser()->setAttribute('dc_report_list.page/'.$report_query->getName(), null);
      $this->getUser()->setAttribute('dc_report_list.sort/'.$report_query->getName(), null);
    }
  }

  protected function getReportQuery()
  {
    $name= $this->getUser()->getAttribute('dc_report_list.query_name',null);
    if (is_null($name)) return null;
    $criteria=new Criteria();
    $criteria->add(dcReportQueryPeer::NAME,$name);
    return dcReportQueryPeer::doSelectOne($criteria);
  }

  public function executeIndex(sfWebRequest $request)
  {
    $rquery_name=$request->getParameter('name');
    if (!empty($rquery_name))
    {
      $this->setReportQuery($rquery_name);
    }
    $this->report_query= $this->getReportQuery();
    
    if (is_null($this->report_query))
    {
      return sfView::ERROR;
    }
    
    if ($request->getParameter('sort'))
    {
      $this->setTestSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }
    if ($request->getParameter('page'))
    {
      $this->setTestPage($request->getParameter('page'));
    }
    
    $this->pager= $this->getPager();  

    $this->export_pager= $this->getExportPager();

    $this->filters = new dcPropelReportFilter($this->report_query);
    $this->filters->setDefaults($this->getFilters());
    $this->sort = $this->getTestSort();
  }

  protected function getPager()
  {
    $pager = new dcPropelReportPager('dcPropelReportPeer',sfConfig::get('app_dc_report_query_list_rows',20));
    $criteria = $this->report_query->getCriteria(); 

    $this->addFiltersCriteria($criteria);
 
    $this->addTestSortCriteria($criteria);
    $pager->setCriteria($criteria);

    $pager->setPage($this->getTestPage());
    $pager->init();
    


    return $pager;
  }

  protected function getExportPager()
  {
    $pager = new dcPropelReportPager('dcPropelReportPeer',sfConfig::get('app_dc_report_query_export_rows',20));
    $criteria = $this->report_query->getCriteria(); 
   
    $this->addFiltersCriteria($criteria);
    $this->addTestSortCriteria($criteria);

    $pager->setCriteria($criteria);
    $pager->setPage(1);
    $pager->init();
    return $pager;
  }

  protected function addFiltersCriteria(Criteria $criteria)
  {
    if (is_null($this->filters))
    {
      $this->filters = new dcPropelReportFilter($this->report_query);
    }
    $this->filters->buildCriteria($this->getFilters(),$criteria);
  }

  public function executeFilter(sfWebRequest $request)
  {
    
    $rquery_name=$request->getParameter('name');
    
    if (!empty($rquery_name))
    {
      $this->setReportQuery($rquery_name);
    }
    $this->report_query = $this->getReportQuery();
    if (is_null($this->report_query))
    {
      return sfView::ERROR;
    }
   
    $this->setTestPage(1);
    
    if ($request->hasParameter('_reset'))
    {
      $this->setFilters(array());
      $this->redirect('@dc_report_list?name='.$this->report_query->getName());
    }

    $this->filters = new dcPropelReportFilter($this->report_query);

    $this->filters->bind($request->getParameter($this->filters->getName()));
    
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());
      $this->redirect('@dc_report_list?name='.$this->report_query->getName());
    }

    $this->pager = $this->getPager();
    $this->export_pager= $this->getExportPager();

    $this->sort = $this->getTestSort();

    $this->setTemplate('index');
  }



  protected function getFilters()
  {
    return $this->getUser()->getAttribute('dc_report_list.filters', array(), 'null');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('dc_report_list.filters', $filters, 'null');
  }

  public function executeExportToExcel(sfWebRequest $request)
  {
	$rquery_name=$request->getParameter('name');

	if (!empty($rquery_name))
	{
		$this->setReportQuery($rquery_name);
	}	
	
	$this->report_query= $this->getReportQuery();
	if (is_null($this->report_query))
	{
		return sfView::ERROR;
	}

	$export_all_rows = $request->getParameter('export_all',false);
	$export_page = $request->getParameter('export_page',1);

	$criteria = $this->report_query->getCriteria(); 
	$this->addFiltersCriteria($criteria);
	$this->addTestSortCriteria($criteria);
	
	if (!class_exists('sfPhpExcel'))	
		return sfView::ERROR;
	try {
        	ini_set("max_execution_time",0); 
		$this->setLayout(false);
		sfConfig::set('sf_web_debug', false);
		
		$resp = $this->getResponse();
		$resp->setHttpHeader('Content-type', 'application/x-excel; charset=UTF-8');
		$resp->setHttpHeader('Content-Disposition', ' attachment; filename="export-'.$this->report_query->getName().'.xls"');
		$resp->setHttpHeader('Cache-Control', ' maxage=3600');
		$resp->setHttpHeader('Pragma', 'public');
	
		if ($export_all_rows)
			$results = dcPropelReportPeer::doSelect($criteria,$this->report_query->getDatabase());	
		else {
			$pager = $this->getExportPager();
			$pager->setPage($export_page);
			$pager->init();
			$results = $pager->getResults();
		}
		
		$objWriter = new PHPExcel_Writer_Excel5($this->buildExcel($this->report_query, $results));
		
		$tmp_dir = '/tmp/';
		$file_name = $tmp_dir.'export'.time().'.xls';
		$objWriter->save($file_name);
		$this->file = $file_name;
		
	
	}
	catch(Exception $e) {
		die($e->getMessage());
		return sfView::ERROR;
	}
  }

  private function buildExcel($report_query, $results)
  {
	$objPHPExcel = new sfPhpExcel();
	$objPHPExcel->setActiveSheetIndex(0);	
	$this->writeHeader($report_query, $objPHPExcel);
	$this->writeRows($report_query,$results, $objPHPExcel);
	return $objPHPExcel;
  }

  private function writeHeader($report_query, $objPHPExcel)
  {
	$column = 0;
	$row    = 1;
	foreach ($report_query->getdcReportFields() as $field) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column,$row, $field->__toString()	);
		$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		$column++;
	}
  }

  private function writeRows($report_query, $results, $objPHPExcel)
  {
	$row    = 2;
	foreach ($results as $data_row) {
		$column = 0;		
		foreach($data_row as $key=>$value) {		
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row,$value);
			$column++;
		}
		$row++;
	}
  }


}
