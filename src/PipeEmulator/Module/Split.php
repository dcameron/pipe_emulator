<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Split.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Split extends ModuleBase implements ModuleInterface {

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);
  }
}
