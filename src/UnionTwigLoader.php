<?php

/**
 * @file
 * Contains \Drupal\union_organizer\UnionTwigLoader.
 */

namespace Drupal\union_organizer;

/**
 * Loads templates from the filesystem.
 *
 * This loader adds the `@union` namespace to the Twig filesystem loader so that
 * templates can be referenced by namespace, like
 * @union/button/button.twig.
 */
class UnionTwigLoader extends \Twig_Loader_Filesystem {

  // Keep track of libraries that we attempt to register.
  // protected $libraries = array();

  /**
   * Constructs a new ComponentsLoader object.
   *
   * @param string|array $paths
   *   A path or an array of paths to check for templates.
   */
  public function __construct($paths = array()) {
    // Don't pass $paths to __contruct() or it will create the default Twig
    // namespace in this Twig loader.
    parent::__construct();

    $paths = [];

    // Find all twig files, including components and skins.
    // @todo Should skins templates be in the same namespace as components?
    $twig_files = file_scan_directory('libraries/union/source/', '/.*\.twig$/', ['key' => 'filename']);

    foreach ($twig_files as $component) {
      // Add the component path (excluding the twig filename) to the path array.
      $paths[] = substr($component->uri, 0, strlen($component->filename) * -1);
    }

    $this->setPaths(array_unique($paths), "union");
  }
}
