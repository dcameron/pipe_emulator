<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Fetch.
 */

namespace PipeEmulator\Module;

/**
 * Defines a fetch pipe module class.
 */
class Fetch extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
