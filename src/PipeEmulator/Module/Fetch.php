<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Fetch.
 */

namespace PipeEmulator\Module;

/**
 * Defines a fetch pipe module class.
 *
 * In Yahoo! Pipes fetch modules were the starting points of pipes. They fetched
 * content from a source providing input for the pipe.
 */
class Fetch extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
