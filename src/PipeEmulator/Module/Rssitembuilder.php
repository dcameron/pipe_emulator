<?php

/*
 * @file
 * Contains \PipeEmulator\Module\Rssitembuilder.
 */

namespace PipeEmulator\Module;

/**
 * Description of output
 *
 * @author David Cameron
 */
class Rssitembuilder extends ModuleBase implements ModuleInterface {

  protected $conf;

  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);

    $this->conf = $module_definition->conf;
  }

  public function evaluateInput($input) {
    $rss_fields = array('title', 'description', 'link', 'pubdate', 'author', 'guid');

    foreach ($rss_fields as $field) {
      if (!isset($input[$field])) {
        continue;
      }

      // The subkey property indicates another field that should be copied into
      // this one.
      if (isset($this->conf->{$field}->subkey) && isset($input[$this->conf->{$field}->subkey])) {
        $input[$field] = $input[$this->conf->{$field}->subkey];
      }
      // The value property indicates text that should be copied into this
      // field. "[object Object]" was a bugged value that occurred in Yahoo
      // Pipes when a value was deleted from this module.
      if (isset($this->conf->{$field}->value) && $this->conf->{$field}->value != '[object Object]') {
        $input[$field] = $this->conf->{$field}->value;
      }
    }
    return $input;
  }
}
