<?php

namespace PipeEmulator\Module;

/**
 * Defines a split pipe module class.
 *
 * In Yahoo! Pipes split modules sent their input to multiple outputs.
 */
class Split extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
