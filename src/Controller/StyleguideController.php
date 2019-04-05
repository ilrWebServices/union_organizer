<?php

namespace Drupal\union_organizer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

  /**
   * Returns a page for dynamically rendering demo union components.
   *
   * @see templates/union-component.html.twig
   */
  public function demo_component(String $component) {
    if ($component) {
      $twig_files = file_scan_directory('libraries/union/source/', '/.*\.twig$/', ['key' => 'filename']);
      if (!array_key_exists($component . '.twig', $twig_files)) {
        throw new NotFoundHttpException();
      }

      $build = [
        '#theme' => 'union_component',
        '#component' => $component,
        '#title' => 'Union ' . $component,
        '#attached' => [
          'library' => [
            'union_organizer/ilr'
          ]
        ],
        '#cache' => [
          'max-age' => 0,
        ]
      ];
    }

    return $build;
  }

}
