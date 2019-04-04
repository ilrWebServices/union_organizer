<?php

namespace Drupal\union_organizer\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * The Union Organizer Styleguide controller.
 */
class StyleguideController extends ControllerBase {

  /**
   * Returns a render array for the styleguide page.
   *
   * @see templates/union-styleguide.html.twig
   */
  public function content() {
    $build = [
      '#theme' => 'union_styleguide',
      '#attached' => [
        'library' => [
          'union_organizer/union_organizer_styleguide',
          'union_organizer/ilr'
        ]
      ],
      '#cache' => [
        'max-age' => 0,
      ]
    ];
    return $build;
  }

}
