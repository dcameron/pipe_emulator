<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Rename.
 */

namespace PipeEmulator\Module;

/**
 * Defines a rename pipe module class.
 */
class Rename extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
