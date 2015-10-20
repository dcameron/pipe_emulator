<?php

/*
 * @file
 * Contains \PipeEmulator\Module\ModuleInterface.
 */

namespace PipeEmulator\Module;

/**
 *
 * @author David Cameron
 */
interface ModuleInterface {

  public function getOutputs();

  public function evaluateInput($input);
}
