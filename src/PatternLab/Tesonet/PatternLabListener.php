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

use \PatternLab\Listener;
use \PatternLab\PatternEngine\Twig\TwigUtil;
use Tesonet\ReactJsTwig\TwigExtension;

class PatternLabListener extends Listener {

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
    // Get the Twig instance loaders (returns false or array of loaders)
    if ($loaders = TwigUtil::getLoaders()) {
      // Get the file system loader
      $fileSystemLoader = array_filter($loaders, function($loader) {
        $class = get_class($loader);
        return ($class === 'Twig_Loader_Filesystem');
      });
      if (!empty($fileSystemLoader)) {
        $fileSystemLoader = reset($fileSystemLoader);
        // create the extension
        $reactExtension = new TwigExtension();
        // add it to Twig
        $instance->addExtension($reactExtension);
        // allow access to the filesystem loader
        $reactExtension->setLoader($fileSystemLoader);
      }
    }

    TwigUtil::setInstance($instance);
  }

}
