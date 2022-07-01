<?php

namespace Drupal\union_organizer;

use Drupal\Core\Template\Attribute;

/**
 * Twig extension with some useful functions and filters.
 *
 * Dependency injection is not used for performance reason.
 */
class UnionTwigExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('union_attributes', [$this, 'unionAttributes']),
      new \Twig_SimpleFunction('union_file', [$this, 'unionFile']),
      new \Twig_SimpleFunction('union_digest', 'sha1'),
    ];
  }

  /**
   * Creates a cross-platform Drupal Attribute object.
   *
   * @param array|Drupal\Core\Template\Attribute $attributes
   *   An array of attribute name/value pairs or an existing attribute object.
   */
  public function unionAttributes($attributes) {
    return is_array($attributes) ? new Attribute($attributes) : $attributes;
  }

  /**
   * Return a full file path to a Union file.
   *
   * E.g. union_file('components/logo/union.svg').
   *
   * @todo Make the file path prefix configurable. How? Dunno!
   *
   * @param string $filepath
   *   A relative file path for a Union component.
   *
   * @return string
   *   Full path
   */
  public function unionFile($filepath) {
    return '/Users/jeff/sites/drupal.ilr.test/vendor/cornell/union/' . $filepath;
  }

}
