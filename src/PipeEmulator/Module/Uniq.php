<?php

namespace PipeEmulator\Module;

/**
 * Defines a uniq pipe module class.
 *
 * In Yahoo! Pipes uniq modules removed duplicate values from their input.
 */
class Uniq extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
