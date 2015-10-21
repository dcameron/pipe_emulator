<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Loop.
 */

namespace PipeEmulator\Module;

/**
 * Defines a loop pipe module class.
 *
 * In Yahoo! Pipes loop modules iterated over each item in the input, sending
 * each item to an embedded sub-module for processing.
 */
class Loop extends ModuleBase implements ModuleInterface {

  /**
   * A ModuleBase object that the loop module uses to process the input.
   *
   * @var ModuleBase
   */
  protected $embed;

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);

    // Build the module that is embedded in the loop.
    $embedded_module = $module_definition->conf->embed->value;
    $type = $embedded_module->type;
    $class = 'PipeEmulator\Module\\' . ucfirst($type);
    $this->embed = new $class($embedded_module, array());
  }

  /**
   * Sends the input to the embedded sub-module for processing.
   */
  public function evaluateInput($input) {
    return $this->embed->evaluateInput($input);
  }

  /**
   * @{inheritdoc}
   */
  public function getContent() {
    return '<div class="embedded-module"><div class="module-label">' . $this->embed->getLabel() . '</div>' . $this->embed->getContent() . '</div>';
  }
}
