<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Output.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Output extends ModuleBase implements ModuleInterface {

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
