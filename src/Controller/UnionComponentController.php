<?php

namespace Drupal\union_organizer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Union\Component;
use Union\Components;

/**
 * Controller for UnionComponents.
 */
class UnionComponentController extends ControllerBase {

  /**
   * Callback for /class/{salesforce_class_id}.
   */
  public function view($component_id) {
    $build = [];
    $components = new Components();

    $component = ($component = $components->getComponent($component_id)) ? $component : $components->getComponent('_' . $component_id);

    if ($component) {
      $build = [
        '#markup' => $component->render(TRUE),
      ];
    }
    else {
      $build = [
        '#markup' => '<h2>Component not found.</h2>',
      ];
    }

    return $build;
  }

}
