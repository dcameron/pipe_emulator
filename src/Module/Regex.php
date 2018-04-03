<?php

namespace PipeEmulator\Module;

/**
 * Defines a regex pipe module class.
 *
 * In Yahoo! Pipes regex modules performed regular expression string replacement
 * on input fields.
 *
 * I think the regex character types, e.g. "\W", are a little different in PHP
 * than they were in Pipes.  If you are getting strange results, you may have to
 * edit the pipe definition to get the same output.
 *
 * @todo Add a function to search the rules for Pipes-specific character types
 *   and replace them with PHP character types.
 */
class Regex extends ModuleBase implements ModuleInterface {

  /**
   * An array of stdClass objects representing regex string replacement rules.
   *
   * Each rule object contains the following properties:
   * - field: The input array element on which to perform the replacement.
   * - match: The regex pattern to find in the input field.
   * - replace: The new string used to replace the matched string.
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

    $this->rules = $module_definition->conf->RULE;
  }

  /**
   * Performs regex string replacement on the input's fields.
   */
  public function evaluateInput($input) {
    foreach ($this->rules as $rule) {
      $field = $rule->field->value;
      $match = '~' . $rule->match->value . '~';
      $replace = $rule->replace->value;
      if (isset($input[$field])) {
        $input[$field] = preg_replace($match, $replace, $input[$field]);
      }
    }
    return $input;
  }

  /**
   * @{inheritdoc}
   */
  public function getContent() {
    $output = '';
    foreach ($this->rules as $rule) {
      $output .= '<p>Field: ' . $rule->field->value . '<br>Match: ' . $rule->match->value . '<br>Replace: ' . $rule->replace->value . '</p>';
    }
    return $output;
  }
}
