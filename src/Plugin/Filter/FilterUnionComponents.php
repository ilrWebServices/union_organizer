<?php

namespace Drupal\union_organizer\Plugin\Filter;

use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;

/**
 * Provides a filter to add some component libraries on demand.
 *
 * @Filter(
 *   id = "filter_union_components",
 *   title = @Translation("Auto Union components"),
 *   description = @Translation("Add Union component libraries when certain component classes are detected."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE,
 * )
 */
class FilterUnionComponents extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $result = new FilterProcessResult($text);
    $libraries = [];

    if (preg_match('/class=".*cu-feature-list.*"/', $text)) {
      $libraries[] = 'union_organizer/feature-list';
    }

    if (preg_match('/class=".*cu-button.*"/', $text)) {
      $libraries[] = 'union_organizer/button';
    }

    $result->addAttachments([
      'library' => $libraries,
    ]);

    return $result;
  }

}
