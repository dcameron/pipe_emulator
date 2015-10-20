<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Union.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Union extends ModuleBase implements ModuleInterface {

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
