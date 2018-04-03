<?php

namespace PipeEmulator\Module;

/**
 * Defines an rssitembuilder pipe module class.
 *
 * In Yahoo! Pipes rssitembuilder modules performed operations on input fields
 * from RSS feed items. At least two operations were possible:
 * - Copying one field to another.
 * - Replacing the contents of a field with a user-defined value.
 */
class Rssitembuilder extends ModuleBase implements ModuleInterface {

  /**
   * A stdClass object with properties whose names represent RSS item fields.
   * Each property is also a stdClass object that will have one of two
   * properties:
   * - subkey: This is the name of another RSS item field whose contents should
   *   be copied into this field.
   * - value: This is a user-defined string that should be copied into this
   *   field.
   *
   * @var stdClass 
   */
  protected $conf;

  /**
   * {@inheritdoc}
   */
  public function __construct($module_definition, $outputs) {
    parent::__construct($module_definition, $outputs);

    $this->conf = $module_definition->conf;
  }

  /**
   * Replaces text in the input's array elements with another value.
   */
  public function evaluateInput($input) {
    // More RSS item elements than these six are included in the conf object. I
    // only needed to check these six when I first wrote this script.
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
      // field.
      if (isset($this->conf->{$field}->value)) {
        // "[object Object]" was a bugged value that occurred in Yahoo Pipes
        // when a value was deleted from this module.
        if ($this->conf->{$field}->value == '[object Object]') {
          $this->conf->{$field}->value = '';
        }
        $input[$field] = $this->conf->{$field}->value;
      }
    }
    return $input;
  }

  /**
   * @{inheritdoc}
   */
  public function getContent() {
    $output = '<div class="rssitembuilder-conf">';
    foreach ($this->conf as $field => $field_conf) {
      $output .= '<div>' . $field . ': ';
      $value = '';
      if (isset($field_conf->subkey)) {
        $output .= 'subkey ';
        $value = $field_conf->subkey;
      }
      elseif (isset($field_conf->value)) {
        $output .= 'value ';
        $value = $field_conf->value;
      }
      $output .= '<input type="text" value="' . $value . '" /></div>';
    }
    $output .= '</div>';
    return $output;
  }
}
