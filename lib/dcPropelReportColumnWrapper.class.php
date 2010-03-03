<?php 
/**
 * dcPropelReportColumnWrapper. 
 *
 *
 * @author Lic. Christian A. Rodriguez <car@cespi.unlp.edu.ar>
 * @author AC. Perez, Juan Pablo       <jpablop@cespi.unlp.edu.ar>
 */

class dcPropelReportColumnWrapper
{
	protected $field = null;
	protected $value = null;

	public function __construct($dcPropelReportFiled)
	{
		$this->field = 	$dcPropelReportFiled;

	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function getValue($emitSignal=false)
	{
	    $res     = $this->value;
	    $event = null;
	    if ($emitSignal)
	    {
	      $event = $this->createEvent();                                            // Creo el evento
	      sfContext::getInstance()->getConfiguration()->getEventDispatcher()->filter($event, $this->value);  // Levanto la señal
	      $res   = $event->getReturnValue();                                        // Obtengo el valor modificado
	    }
	    if (is_null($event) || (!$event->isProcessed() && !empty($value)))
	    {
	      // Si el evento no se procesó, obtengo el valor normalmente
	      $res = $this->value;
	    }
	    return $res;		
	}


        protected function createEvent()
        {
	    return new sfEvent(
	      $this,                                                           // Objeto que levanto la señal
	      'dc_propel_report_query_'.$this->field->getRealColumnName(),	      // Nombre de la señal
	      array('fieldName' => $this->field->__toString())                      // Lista de parámetros
	    );
	}

}
