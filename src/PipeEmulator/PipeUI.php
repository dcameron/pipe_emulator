<?php

/*
 * @file
 * Contains \PipeEmulator\Pipe.
 */

namespace PipeEmulator;

/**
 * Defines a pipe user interface class.
 *
 * This class is used to create a visual representation of a pipe, similar to
 * how it appeared in the Yahoo! Pipes UI. Currently, this replacement UI is
 * static. Elements cannot be moved or edited. Also, there are no wires
 * connecting the modules. In the future, it may be possible to extend the
 * functionality of the class to allow those abilities.
 *
 * I initially wrote this as quick and dirty procedural code just so I could see
 * the layout of modules in some very complex pipes. I actually printed out the
 * results and drew the connections myself. I didn't want to lose that code in
 * case I wanted to build out a replacement editing UI in the future, so I built
 * this class to contain it.
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

  /**
   * Builds an HTML representation of the pipe's modules.
   *
   * @return string
   *   The rendered HTML of the pipe.
   */
  function renderPipe() {
    $layout = $this->pipe->getLayout();
    $output = '<style>.module { background: #EEEEEE; border: 1px solid #000000; border-radius: 3px; padding: 2px; position: absolute; width: 200px;} .module-label { font-weight: bold; }</style>';

    foreach ($this->pipe->getModules() as $id => $module) {
      $output .= '<div class="module" style="top: ' . ($layout[$id]['y'] + 100) . 'px; left: ' . ($layout[$id]['x'] + 100) . 'px;">';
      $output .= '<div class="module-label">' . $module->getLabel() . '</div>';
      $content = $module->getContent();
      if ($content != '') {
        $output .= $content;
      }
      $output .= '</div>';
    }
    return $output;
  }
}
