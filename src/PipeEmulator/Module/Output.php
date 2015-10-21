<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Output.
 */

namespace PipeEmulator\Module;

/**
 * Defines an output pipe module class.
 */
class Output extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
