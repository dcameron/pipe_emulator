<?php

/*
 * @file
 * Contains \PipeEmulator\Module\ModuleBase.
 */

namespace PipeEmulator\Module;

/**
 * Description of ModuleBase
 *
 * @author David Cameron
 */
abstract class ModuleBase implements ModuleInterface {

  protected $id;

  protected $outputs = array();

  public function __construct($module_definition, $outputs) {
    $this->id = $module_definition->id;
    $this->outputs = $outputs;
  }

  public function getOutputs() {
    return $this->outputs;
  }

  public function evaluateInput($input) {
    return $input;
  }
}
