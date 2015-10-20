<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Filter.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Filter extends ModuleBase implements ModuleInterface {

  /**
   * 'permit' or 'block' the input if all rules pass.
   *
   * @var string 
   */
  protected $mode;

  /**
   * 'and' or 'or' the results of the rules.
   *
   * @var string 
   */
  protected $combine;

  protected $rules = array();

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);

    $this->mode = $module_definition->conf->MODE->value;
    $this->combine = $module_definition->conf->COMBINE->value;
    $this->rules = $module_definition->conf->RULE;
  }

  public function evaluateInput($input) {
    $results = array();

    foreach ($this->rules as $key => $rule) {
      $field = $rule->field->value;
      $op = $rule->op->value;
      $value = $rule->value->value;

      if ($op == 'contains') {
        $results[$key] = strripos($input[$field], $value) !== FALSE ? TRUE : FALSE;
      }
      else {
        echo $this->id . ' rule number ' . $key . ' has an op that is not "contains"!!!';
      }
    }

    $combined_result = FALSE;
    if ($this->combine == 'and') {
      $combined_result = !in_array(FALSE, $results);
    }
    elseif($this->combine == 'or') {
      $combined_result = in_array(TRUE, $results);
    }

    if ($this->mode == 'permit') {
      return $combined_result ? $input : FALSE;
    }
    elseif ($this->mode == 'block') {
      return !$combined_result ? $input: FALSE;
    }
    else {
      return FALSE;
    }
  }
}
