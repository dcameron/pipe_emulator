<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Rename.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Rename extends ModuleBase implements ModuleInterface {

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
