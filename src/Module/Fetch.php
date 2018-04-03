<?php

namespace PipeEmulator\Module;

/**
 * Defines a fetch pipe module class.
 *
 * In Yahoo! Pipes fetch modules were the starting points of pipes. They fetched
 * content from a source providing input for the pipe.
 */
class Fetch extends ModuleBase implements ModuleInterface {

  /**
   * The URL that is fetched by this module.
   *
   * @var string
   */
  protected $url;

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);

    $this->url = $module_definition->conf->URL->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getContent() {
    return '<label for="' . $this->id . '-fetch-url">URL</label><input type="text" id="' . $this->id . '-fetch-url" name="' . $this->id . '-fetch-url" class="fetch-url" value="' . $this->url . '" />';
  }
}
