<?php

class dcValidatorNumberRange extends sfValidatorBase
{

  protected function configure($options = array(), $messages = array())
  {
    $this->addMessage('invalid', 'The begin number must be before the end number.');

    $this->addRequiredOption('from_number');
    $this->addRequiredOption('to_number');
  }

  protected function doClean($value)
  {
    $value['from'] = $this->getOption('from_number')->clean(isset($value['from']) ? $value['from'] : null);
    $value['to']   = $this->getOption('to_number')->clean(isset($value['to']) ? $value['to'] : null);

    if ($value['from'] && $value['to'])
    {
      $v = new sfValidatorSchemaCompare('from', sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'to', array('throw_global_error' => true), array('invalid' => $this->getMessage('invalid')));
      $v->clean($value);
    }

    return $value;
  }
}

