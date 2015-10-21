<?php

/*
 * @file
 * Contains \PipeEmulator\Pipe.
 */

namespace PipeEmulator\PipeUI;

/**
 * Defines a pipe user interface class.
 */
class PipeUI {

  /**
   * The pipe to be displayed.
   *
   * @var PipeEmulator\Pipe 
   */
  protected $pipe;

  /**
   * Constructs a pipe user interface object.
   *
   * @param \PipeEmulator\Pipe $pipe
   *   The pipe to be displayed by the user interface.
   */
  function __construct(\PipeEmulator\Pipe $pipe) {
    $this->pipe = $pipe;
  }
}
