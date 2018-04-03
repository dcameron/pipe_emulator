<?php

namespace PipeEmulator\Module;

/**
 * Defines an output pipe module class.
 *
 * In Yahoo! Pipes output modules were the end point of the pipe.
 */
class Output extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
