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

	const FORMAT_HTML =  'HTML';
	const FORMAT_EXCEL = 'EXCEL';

	public function __construct($dcPropelReportFiled)
	{
		$this->field = 	$dcPropelReportFiled;

	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function getValue($format = 'HTML')
	{
    $res     = $this->value;
    $event = null;

    $event = $this->createEvent($format); // Creo el evento
    sfContext::getInstance()->getConfiguration()->getEventDispatcher()->filter($event, $this->value);  // Levanto la señal
    $res   = $event->getReturnValue(); // Obtengo el valor modificado
    
    if (is_null($event) || (!$event->isProcessed() && !empty($value)))
    {
      // Si el evento no se procesó, obtengo el valor normalmente
      $res = $this->value;
    }
    return $res;		
	}


  protected function createEvent($format)
  {
    return new sfEvent(
      $this,                            // Objeto que levanto la señal
      'dc_propel_report.render_value',  // Nombre de la señan
      array(                            // Lista de parámetros
        'format'    => $format,
        'field' => $this->field) 
    );
	}

}
