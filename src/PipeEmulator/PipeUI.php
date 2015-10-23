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
  public function __construct(\PipeEmulator\Pipe $pipe) {
    $this->pipe = $pipe;
  }

  /**
   * Builds an HTML representation of the pipe's modules.
   *
   * @return string
   *   The rendered HTML of the pipe.
   */
  public function renderPipe() {
    $layout = $this->pipe->getLayout();
    list($x_offset, $y_offset) = $this->getCoordinateOffsets($layout);

    $output = '<head><style>.module, .embedded-module { background: #EEEEEE; border: 1px solid #000000; border-radius: 3px; padding: 2px;} .module { position: absolute; width: 200px; } .module-label { font-weight: bold; } .rssitembuilder-conf { height: 252px; overflow: scroll; }</style></head><body>';

    foreach ($this->pipe->getModules() as $id => $module) {
      $output .= '<div class="module" style="top: ' . ($layout[$id]['y'] + $y_offset) . 'px; left: ' . ($layout[$id]['x'] + $x_offset) . 'px;">';
      $output .= '<div class="module-label">' . $module->getLabel() . '</div>';
      $content = $module->getContent();
      if ($content != '') {
        $output .= $content;
      }
      $output .= '</div>';
    }
    return $output . '</body>';
  }

  /**
   * Returns offsets to add to the x and y coordinates of modules in the pipe.
   *
   * In Yahoo! Pipes, the coordinates of modules could have negative values. If
   * those negative values are applied to the positions of HTML elements, then
   * they will be rendered off-screen. Find the lowest negative values and
   * return them so they can be used to offset the positions of the modules.
   *
   * @param array $layout
   *   An array of module position coordinates.
   *
   * @return array
   *   Element 0 contains the x-axis offset. Element 1 contains the y-axis
   *   offset.
   */
  protected function getCoordinateOffsets($layout) {
    $x_offset = 0;
    $y_offset = 0;

    foreach ($layout as $module) {
      if ($module['x'] < $x_offset) {
        $x_offset = (int) $module['x'];
      }
      if ($module['y'] < $y_offset) {
        $y_offset = (int) $module['y'];
      }
    }

    // Add an extra 10px to the offset values for some padding.
    return array(abs($x_offset) + 10, abs($y_offset) + 10);
  }
}
