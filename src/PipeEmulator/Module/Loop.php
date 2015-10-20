<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Loop.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Loop extends ModuleBase implements ModuleInterface {

  protected $embed;

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);

    // Build the module that is embedded in the loop.
    $embedded_module = $module_definition->conf->embed->value;
    $type = $embedded_module->type;
    $class = 'PipeEmulator\Module\\' . ucfirst($type);
    $this->embed = new $class($embedded_module, array());
  }

  public function evaluateInput($input) {
    return $this->embed->evaluateInput($input);
  }
}
