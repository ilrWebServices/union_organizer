<?php

namespace Drupal\union_organizer;

use Union\Components;

/**
 * Loads templates from the filesystem.
 *
 * This loader adds the `@union` namespace to the Twig filesystem loader so that
 * templates can be referenced by namespace, like:
 *
 * @union/button/button.twig.
 */
class UnionTwigLoader extends \Twig_Loader_Filesystem {

  /**
   * Constructs a new ComponentsLoader object.
   *
   * @param string|array $paths
   *   A path or an array of paths to check for templates.
   */
  public function __construct($paths = []) {
    // Don't pass $paths to __contruct() or it will create the default Twig
    // namespace in this Twig loader.
    parent::__construct();

    $union_components = new Components;
    $paths = [];

    foreach ($union_components->getComponents() as $component) {
      $paths[] = realpath($component->template->getPath());
    }

    $this->setPaths(array_unique($paths), "union");
  }

}
