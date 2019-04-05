<?php

namespace Drupal\union_organizer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * The Union Organizer Styleguide controller.
 */
class StyleguideController extends ControllerBase {

  /**
   * Dynamically renders all demo components.
   *
   * @see templates/union-styleguide.html.twig
   */
  public function content() {
    $demo_components = [];
    $twig_files = file_scan_directory('libraries/union/source/', '/.*\.twig$/', ['key' => 'filename']);
    foreach ($twig_files as $file_info) {
      if (strpos($file_info->filename, '_') !== 0) {
        $demo_components[$file_info->name] = $file_info->filename;
      }
    }
    $build = [
      '#theme' => 'union_styleguide',
      '#components' => $demo_components,
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
