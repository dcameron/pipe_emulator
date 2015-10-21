<?php

/*
 * @file
 * Contains \PipeEmulator\Pipe.
 */

namespace PipeEmulator;

/**
 * Defines a pipe class.
 */
class Pipe {

  /**
   * A decoded JSON object representing a Yahoo! Pipe definition.
   *
   * @var stdClass
   */
  protected $pipe;

  /**
   * An array of connections between pipe modules.
   *
   * The array is keyed by the outputting module's ID. Each value in the array
   * is a nested array of other module IDs to which the output should be sent.
   *
   * @var array
   */
  protected $tree = array();

  /**
   * An array of ModuleBase objects representing modules that are defined in the
   * pipe.
   *
   * @var array
   */
  protected $modules = array();

  /**
   * An array of module position coordinates, keyed by module ID.
   *
   * @var array 
   */
  protected $layout = array();

  /**
   * Constructs a pipe object.
   *
   * @param string $pipe_definition
   *   A string containing a JSON object that represents a Yahoo! Pipes pipe.
   */
  public function __construct($pipe_definition) {
    $this->pipe = json_decode($pipe_definition);
    // The portion of the pipe object that contains the functionality
    // information must be decoded a second time.
    $pipe_working = json_decode($this->pipe->PIPE->working);

    // Build the pipe's tree.
    $this->buildTree($pipe_working);

    // Build the pipe's modules.
    $this->buildModules($pipe_working);

    // Build the module positions array.
    $this->buildLayout($pipe_working);
  }

  /**
   * Returns the pipe's connection tree array.
   */
  public function getTree() {
    return $this->tree;
  }

  /**
   * Returns the pipe's modules array.
   */
  public function getModules() {
    return $this->modules;
  }

  /**
   * Returns the pipe's module layout array.
   */
  public function getLayout() {
    return $this->layout;
  }

  /**
   * Extracts the tree of module connections from the pipe definition.
   *
   * @param stdClass $pipe_working
   *   Part of the pipe definition that contains a wires array property.
   */
  protected function buildTree($pipe_working) {
    foreach ($pipe_working->wires as $wire) {
      $this->tree[$wire->src->moduleid][] = $wire->tgt->moduleid;
    }
  }

  /**
   * Extracts the module definitions from the pipe definition.
   *
   * @param stdClass $pipe_working
   *   Part of the pipe definition that contains a modules array property.
   */
  protected function buildModules($pipe_working) {
    foreach ($pipe_working->modules as $module) {
      $type = $module->type;
      $class = 'PipeEmulator\Module\\' . ucfirst($type);
      $outputs = isset($this->tree[$module->id]) ? $this->tree[$module->id] : array();
      $this->modules[$module->id] = new $class($module, $outputs);
    }
  }

  /**
   * Sends each item in the input array to the module tree for processing.
   *
   * @param array $input
   *   An array of items to be processed by the tree.  Each item should be a
   *   nested associative array of values that are keyed by field name.
   *
   * @return array
   *   The input array after the module tree has completed processing it.
   */
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

  /**
   * Locates a fetch module within the module tree to use as a start point.
   *
   * Pipes were capable of having multiple fetch modules as inputs, but this
   * method only locates the first fetch module within the tree to use as a
   * start point for the pipe. This was done to save time since all of the
   * pipes used when developing this script only had single fetch modules. Also,
   * it wasn't necessary for the fetch module to do anything since the input
   * array was supplied from outside the pipe. We were only interested in having
   * the input processed by other module types. As a result, if this class is
   * utilized by someone else in the future, you may have to override or extend
   * this method to allow for multiple fetch modules.
   *
   * @return string|FALSE
   *   The ID of a fetch module to use as a starting point or FALSE if no fetch
   *   module was found.
   */
  protected function findStartModule() {
    foreach ($this->modules as $id => $module) {
      if ($module instanceof \PipeEmulator\Module\Fetch) {
        return $id;
      }
    }
    return FALSE;
  }

  /**
   * Sends input items to pipe modules for processing.
   *
   * This method processes the input item through the pipe module indicated by
   * the start_id. If the module returns FALSE, then the item was rejected by
   * the module, for instance if the item was filtered out. Otherwise, the
   * processed input is then sent to any modules below the start module in the
   * tree.
   *
   * At the end, the results of the processing by the module and any modules
   * below it are returned.
   *
   * @param string $start_id
   *   The ID of the module used to process the input.
   * @param array $input
   *   An associative array of values that are keyed by field name.
   *
   * @return array|FALSE
   *   The processed input array or FALSE if the start module or any in the tree
   *   below it rejected the input.
   */
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

  protected function buildLayout($pipe_working) {
    foreach ($pipe_working->layout as $module) {
      $this->layout[$module->id]['x'] = $module->xy[0];
      $this->layout[$module->id]['y'] = $module->xy[1];
    }
  }
}
