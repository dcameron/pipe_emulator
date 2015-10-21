<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Filter.
 */

namespace PipeEmulator\Module;

/**
 * Defines a filter pipe module class.
 *
 * In Yahoo! Pipes filter modules filtered items from the pipe input based on a
 * set of rules. The module could be configured to 'and' or 'or' the results of
 * the filter rules in the module. It could also be configured to permit or
 * block items if the combined result passed.
 */
class Filter extends ModuleBase implements ModuleInterface {

  /**
   * 'permit' or 'block' the input if the combined result of the filter rules
   * passed.
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

  /**
   * An array of stdClass objects representing filter rules. Each rule object
   * contains the following properties:
   * - field: The input array element to check with the filter.
   * - op: What kind of filtration operation to perform on the field. Currently
   *   only 'contains' is defined here. Presumably there should be a 'does not
   *   contain' operation and possibly even more, but when creating this script
   *   none of the pipe definitions I had used any operation other than
   *   'contains'. As a result, I don't know what all possible values there are
   *   for the op property.
   * - value: The value the filter checks for in the item element.
   *
   * Each of the above rule properties has a value property that actually
   * contains the value to be used in processing.
   *
   * @var array 
   */
  protected $rules = array();

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);

    $this->mode = $module_definition->conf->MODE->value;
    $this->combine = $module_definition->conf->COMBINE->value;
    $this->rules = $module_definition->conf->RULE;
  }

  /**
   * Filters an input item based on the module's rules.
   *
   * If the item passes the rules, then it will either be permitted (the input
   * will be returned) or blocked (FALSE will be returned).
   */
  public function evaluateInput($input) {
    // Contains the results of the filtration rules.
    $results = array();

    // Evaluate each filtration rule and store the result in $results.
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

    // Get the combined result of all the filtration rules.
    $combined_result = FALSE;
    // If the rule results should be "anded" together, the results array cannot
    // contain FALSE to pass.
    if ($this->combine == 'and') {
      $combined_result = !in_array(FALSE, $results);
    }
    // If the rule results should be "ored" together, the results array must
    // contain TRUE to pass.
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
