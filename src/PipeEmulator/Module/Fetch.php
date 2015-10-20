<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Fetch.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Fetch extends ModuleBase implements ModuleInterface {

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
