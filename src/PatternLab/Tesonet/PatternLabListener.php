<?php

/**
 * Tesonet Listener Class
 *
 * Licensed under the MIT license
 *
 * Adds Tesonet support to the Twig Pattern Engine
 *
 */

namespace PatternLab\Tesonet;

use \PatternLab\PatternEngine\Twig\TwigUtil;
use Tesonet\ReactJsTwig\TwigExtension;

class PatternLabListener extends \PatternLab\Listener {

  /**
   * Add the listeners for this plug-in
   */
  public function __construct() {

    $this->addListener("twigPatternLoader.customize","addExtensions");

  }

  /**
   * Add the extensions to the appropriate instance
   */
  public function addExtensions() {

    $instance = TwigUtil::getInstance();
    // create the extension
    $reactExtension = new TwigExtension();
    // add it to Twig
    $instance->addExtension($reactExtension);
    // allow access to the filesystem loader
    $filesystemLoader = \PatternLab\Template::getFilesystemLoader();
    $reactExtension->setLoader($filesystemLoader);

    TwigUtil::setInstance($instance);
  }

}
