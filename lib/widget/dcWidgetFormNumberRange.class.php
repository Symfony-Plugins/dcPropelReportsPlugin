<?php


class dcWidgetFormNumberRange extends sfWidgetForm
{

  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('from_number');
    $this->addRequiredOption('to_number');

    $this->addOption('template', 'from %from_number% to %to_number%');
  }


  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $values = array_merge(array('from' => '', 'to' => '', 'is_empty' => ''), is_array($value) ? $value : array());

    return strtr($this->getOption('template'), array(
      '%from_number%'      => $this->getOption('from_number')->render($name.'[from]', $value['from']),
      '%to_number%'        => $this->getOption('to_number')->render($name.'[to]', $value['to']),
    ));
  }


  public function getStylesheets()
  {
    return array_unique(array_merge($this->getOption('from_number')->getStylesheets(), $this->getOption('to_number')->getStylesheets()));
  }


  public function getJavaScripts()
  {
    return array_unique(array_merge($this->getOption('from_number')->getJavaScripts(), $this->getOption('to_number')->getJavaScripts()));
  }
}
