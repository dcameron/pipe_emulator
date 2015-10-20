<?php

/*
 * @file
 * Contains \PipeEmulator\Pipe.
 */

namespace PipeEmulator;

/**
 * Description of Pipe
 *
 * @author David Cameron
 */
class Pipe {

  protected $pipe;

  protected $pipe_internals;

  protected $tree = array();

  protected $modules = array();

  public function __construct($pipe_definition) {
    $this->pipe = json_decode($pipe_definition);
    $this->pipe_internals = json_decode($this->pipe->PIPE->working);

    // Build the pipe's tree.
    $this->buildTree();

    // Build the pipe's modules.
    $this->buildModules();
  }

  protected function buildTree() {
    foreach ($this->pipe_internals->wires as $wire) {
      $this->tree[$wire->src->moduleid][] = $wire->tgt->moduleid;
    }
  }

  protected function buildModules() {
    foreach ($this->pipe_internals->modules as $module) {
      $type = $module->type;
      $class = 'PipeEmulator\Module\\' . ucfirst($type);
      $outputs = isset($this->tree[$module->id]) ? $this->tree[$module->id] : array();
      $this->modules[$module->id] = new $class($module, $outputs);
    }
  }

  public function processInput($input) {
    $processed_input = array();
    $start_id = $this->findStartModule();

    foreach ($input as $data) {
      $result = $this->traverseTree($start_id, $data);
      if ($result) {
        $processed_input[] = $result;
      }
    }
    return $processed_input;
  }

  protected function findStartModule() {
    foreach ($this->modules as $id => $module) {
      if ($module instanceof \PipeEmulator\Module\Fetch) {
        return $id;
      }
    }
    return FALSE;
  }

  protected function traverseTree($start_id, $input) {
    $module = $this->modules[$start_id];
    $evaluated_input = $module->evaluateInput($input);
    if ($evaluated_input === FALSE) {
      return FALSE;
    }

    $outputs = $module->getOutputs();
    // If there are no outputs then we've reached the end of the tree.
    if (empty($outputs)) {
      return $evaluated_input;
    }

    // Have the modules below this one in the tree evaluate the input.
    $result = FALSE;
    foreach ($outputs as $output) {
      $output_evaluation = $this->traverseTree($output, $evaluated_input);
      if ($output_evaluation) {
        $result = $output_evaluation;
      }
    }
    return $result;
  }
}
