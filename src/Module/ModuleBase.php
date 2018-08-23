<?php

namespace PipeEmulator\Module;

/**
 * Defines a base pipe module class.
 */
abstract class ModuleBase implements ModuleInterface {

  /**
   * The module's ID.
   *
   * @var string
   */
  protected $id;

  /**
   * An array of module IDs to which the output of this module should be sent.
   *
   * @var array
   */
  protected $outputs = array();

  /**
   * Constructs a pipe module object.
   *
   * @param stdClass $module_definition
   *   An object representing a module that was extracted from a decoded Yahoo!
   *   Pipes definition JSON object.
   * @param array $outputs
   *   An array of module IDs.
   */
  public function __construct($module_definition, $outputs) {
    $this->id = $module_definition->id;
    $this->outputs = $outputs;
  }

  /**
   * {@inheritdoc}
   */
  public function getOutputs() {
    return $this->outputs;
  }

  /**
   * Returns the $input array with no additional processing.
   */
  public function evaluateInput($input) {
    return $input;
  }

  /**
   * @{inheritdoc}
   */
  public function getLabel() {
    return $this->id . ' - ' . substr(get_class($this), 20);
  }

  /**
   * @{inheritdoc}
   */
  public function getContent() {
    return '';
  }

  /**
   * @{inheritdoc}
   */
  public function getYaml() {
    return $this->id . ":\n  type: " . substr(get_class($this), 20) . "\n  outputs:\n    - " . implode("\n    - ", $this->outputs);
  }

}
