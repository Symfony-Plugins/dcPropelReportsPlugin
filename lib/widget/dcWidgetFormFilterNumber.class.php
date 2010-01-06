<?php

class dcWidgetFormFilterNumber extends dcWidgetFormNumberRange
{

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('with_empty', true);
    $this->addOption('empty_label', 'is empty');
    $this->addOption('template', 'from %from_number%<br />to %to_number%');
    $this->addOption('filter_template', '%number_range%<br />%empty_checkbox% %empty_label%');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $values = array_merge(array('is_empty' => ''), is_array($value) ? $value : array());

    return strtr($this->getOption('filter_template'), array(
      '%number_range%'     => parent::render($name, $value, $attributes, $errors),
      '%empty_checkbox%' => $this->getOption('with_empty') ? $this->renderTag('input', array('type' => 'checkbox', 'name' => $name.'[is_empty]', 'checked' => $values['is_empty'] ? 'checked' : '')) : '',
      '%empty_label%'    => $this->getOption('with_empty') ? $this->renderContentTag('label', $this->getOption('empty_label'), array('for' => $this->generateId($name.'[is_empty]'))) : '',
    ));
  }
}
