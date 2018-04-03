<?php

namespace PipeEmulator\Module;

/**
 * Defines a substr pipe module class.
 */
class Substr extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
