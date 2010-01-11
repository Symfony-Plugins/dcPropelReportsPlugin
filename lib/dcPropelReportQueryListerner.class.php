<?php 

/**
 * dcPropelReportQueryListener Build Criteria Event Listener
 *
 * This class is responsible of apply filters to some administraion 
 * list actions of this plugin
 *
 * @author AC. Juan Pablo Perez <jpablop@cespi.unlp.edu.ar>
 */
class dcPropelReportQueryListener
{

  public static function addCriteria(sfEvent $event, $criteria)
  {

    if ($event->getSubject() instanceof autoDc_report_fieldActions)  
    { 
	  	$user = sfContext::getInstance()->getUser();
	  	$criteria->add(dcReportFieldPeer::DC_REPORT_QUERY_ID,$user->getAttribute('dc_report_query/current_report'));
    }
    if ($event->getSubject() instanceof autoDc_report_tableActions)  
    { 
	  	$user = sfContext::getInstance()->getUser();
	  	$criteria->add(dcReportTablePeer::DC_REPORT_QUERY_ID,$user->getAttribute('dc_report_query/current_report'));
	  	$criteria->addAscendingOrderByColumn(dcReportTablePeer::ID);
    }
    
    if ($event->getSubject() instanceof autoDc_report_filterActions)  
    { 
	  	$user = sfContext::getInstance()->getUser();
	  	$criteria->add(dcReportFilterPeer::DC_REPORT_QUERY_ID,$user->getAttribute('dc_report_query/current_report'));
    }

    return $criteria;
  }
  
}
