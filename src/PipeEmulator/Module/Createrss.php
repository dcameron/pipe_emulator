<?php

namespace PipeEmulator\Module;

/**
 * Defines a createrss pipe module class.
 */
class Createrss extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
