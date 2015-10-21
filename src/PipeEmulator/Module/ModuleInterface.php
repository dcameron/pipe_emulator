<?php

/*
 * @file
 * Contains \PipeEmulator\Module\ModuleInterface.
 */

namespace PipeEmulator\Module;

/**
 * Provides an interface for defining a pipe module.
 */
interface ModuleInterface {

  /**
   * Gets the outputs of the module.
   *
   * @return array
   *   Returns the value of the $outputs property.
   */
  public function getOutputs();

  /**
   * Performs some processing task on the input.
   *
   * @param array $input
   *   An associative array of values to be processed.
   *
   * @return FALSE|array
   *   FALSE if the input should not be passed to the next module(s) in the
   *   pipe.  Array containing the results of the processed input.
   */
  public function evaluateInput($input);
}
