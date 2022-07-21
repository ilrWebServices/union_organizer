<?php

namespace Drupal\union_organizer;

use Union\Components;
use Twig\Loader\LoaderInterface;
use Twig\Error\LoaderError;
use Twig\Source;

/**
 * Loads templates from Union.
 *
 * This custom loader provides a `@union` namespace for Union twig templates.
 * The following formats are allowed:
 *
 * - @union/_card.twig
 * - @union/_card
 */
class UnionTwigLoader implements LoaderInterface  {

  protected $components = [];

  /**
   * Constructs a new UnionTwigLoader object.
   */
  public function __construct() {
    $union_components = new Components;

    foreach ($union_components->getComponents() as $component) {
      $this->components['@union/' . $component->id() . '.twig'] = $component;
      $this->components['@union/' . $component->id()] = $component;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceContext($name) {
    $name = (string) $name;

    if (!isset($this->components[$name])) {
      throw new LoaderError(sprintf('Template "%s" is not defined.', $name));
    }

    $component_source = file_get_contents($this->components[$name]->template->getPathName());

    if ($this->components[$name]->getCss() || $this->components[$name]->getJs()) {
      // Append an `{{ attach_library() }}` call to the source of the component.
      $library_id = 'union_organizer/' . preg_replace('/^_*/', '', $this->components[$name]->id());
      $component_source .= PHP_EOL . "{{ attach_library('$library_id') }}";
    }

    return new Source($component_source, $name);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheKey($name) {
    if (!isset($this->components[$name])) {
      throw new LoaderError(sprintf('Template "%s" is not defined.', $name));
    }

    return $name;
  }

  /**
   * {@inheritdoc}
   */
  public function isFresh($name, $time) {
    if (!isset($this->components[$name])) {
      throw new LoaderError(sprintf('Template "%s" is not defined.', $name));
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function exists($name) {
    return isset($this->components[$name]);
  }

}
