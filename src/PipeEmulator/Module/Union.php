<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Union.
 */

namespace PipeEmulator\Module;

/**
 * Defines a union pipe module class.
 *
 * In Yahoo! Pipes union modules combined multiple inputs together.
 */
class Union extends ModuleBase implements ModuleInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
