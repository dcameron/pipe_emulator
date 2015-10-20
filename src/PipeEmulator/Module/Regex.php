<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Regex.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Regex extends ModuleBase implements ModuleInterface {

  protected $rules = array();

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);

    $this->rules = $module_definition->conf->RULE;
  }

  public function evaluateInput($input) {
    foreach ($this->rules as $rule) {
      $field = $rule->field->value;
      $match = '~' . $rule->match->value . '~';
      $replace = $rule->replace->value;
      $input[$field] = preg_replace($match, $replace, $input[$field]);
    }
    return $input;
  }
}
