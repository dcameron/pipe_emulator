<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Split.
 */

namespace PipeEmulator\Module;

/**
 * Defines a split pipe module class.
 */
class Split extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
