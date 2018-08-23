<?php

namespace PipeEmulator;

/**
 * Generates YAML representations of Pipe module definitions.
 */
class PipeYaml {

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
  public function __construct(\PipeEmulator\Pipe $pipe) {
    $this->pipe = $pipe;
  }

  /**
   * Returns YAML representations of the Pipe's module definitions.
   *
   * @return string
   *   The rendered HTML of the pipe.
   */
  public function dumpPipe() {
    $output = [];
    foreach ($this->pipe->getModules() as $id => $module) {
      $yaml = $module->getYaml();
      if ($yaml != '') {
        $output[] = $yaml;
      }
    }
    return implode("\n\n", $output);
  }

}
