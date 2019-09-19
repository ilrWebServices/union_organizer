<?php

/**
 * @file
 * Contains \Drupal\union_organizer\UnionTwigExtension.
 * @see twig_tweak for example code
 */

namespace Drupal\union_organizer;

use \Drupal\Core\Template\Attribute;

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
   * @param array|Attribute $attributes
   * @return void
   */
  public function unionAttributes($attributes) {
    return is_array($attributes) ? new Attribute($attributes) : $attributes;
  }

  /**
   * Return a full file path to a Union file.
   *
   * E.g. union_file('components/logo/union.svg').
   *
   * @todo
   *   - Make the file path prefix configurable. How? Dunno!
   *
   * @param string $filepath
   * @return string Full path
   */
  public function unionFile($filepath) {
    return '/libraries/union/source/' . $filepath;
  }

}
