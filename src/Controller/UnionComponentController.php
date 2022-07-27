<?php

namespace Drupal\union_organizer\Controller;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Union\Components;
use Parsedown as Parsedown;
use phpDocumentor\Reflection\Types\String_;

/**
 * Controller for UnionComponents.
 */
class UnionComponentController extends ControllerBase {

  /**
   * Callback for /union/components.
   */
  public function componentsView() {
    $build = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#title' => '',
      '#items' => [],
      '#empty' => $this->t('No components.'),
    ];
    $components = new Components();

    foreach ($components->getComponents() as $component) {
      $build['#items'][] = [
        '#theme' => 'component_info',
        '#label' => $component->getLabel() ?? $component->id(),
        '#description' => (new Parsedown())->text($component->getDescription()),
        '#url' => Url::fromRoute('union_organizer.component.view', [
          'component_id' => $component->id(),
        ]),
      ];
    }

    return $build;
  }

  /**
   * Callback for /union/components/{component_id}.
   */
  public function componentView($component_id) {
    $build = [];
    $components = new Components();
    $component = $components->getComponent($component_id, TRUE);

    // Re-build asset libraries to support changes to the source code in vendor/
    // during development. @see union_organizer_library_info_build().
    \Drupal::service('library.discovery.parser')->buildByExtension('union_organizer');

    if ($component) {
      $component_source = file_get_contents($component->template->getPathName());
      $library_id = 'union_organizer/' . preg_replace('/^_*/', '', $component->id());
      $template_vars = $component->getTemplateVars();
      $string_vars = [];

      /** @var \phpDocumentor\Reflection\DocBlock\Tags\Var_ $var */
      foreach ($template_vars as $var) {
        if ($var->getType() instanceof String_) {
          $string_vars[] = $var->getVariableName();
        }
      }

      $build['info'] = [
        '#theme' => 'component_info',
        '#label' => $component->getLabel() ?? $component->id(),
        '#description' => (new Parsedown())->text($component->getDescription()),
        '#template_vars' => $template_vars,
        '#reference_links' => $component->getReferences(),
      ];

      foreach ($component->getDemoData() as $demo_num => $demo_data_item) {
        // Convert all string values into a FormattableMarkup object to prevent
        // autoescaping of HTML. See https://www.drupal.org/node/2296163
        foreach ($demo_data_item as $demo_var_name => $demo_var_value) {
          if (in_array($demo_var_name, $string_vars)) {
            $demo_data_item[$demo_var_name] = new FormattableMarkup($demo_var_value, []);
          }
        }

        $build['demo'][$demo_num] = [
          '#type' => 'container',
          '#attributes' => [
            'style' => 'padding-top: 1em; margin: 2em 0; border-top: 2px solid #b31b1b;',
          ],
        ];

        if (isset($demo_data_item['demo_label'])) {
          $build['demo'][$demo_num]['label'] = [
            '#markup' => '<a href="#' . $demo_num . '" >🔗</a><h3 id="' . $demo_num . '" class="cu-heading">' . $demo_data_item['demo_label'] . '</h3>',
          ];
        }

        $build['demo'][$demo_num]['item'] = [
          '#type' => 'container',
          '#attributes' => [
            'style' => 'margin: 2em 0; background: #ccc; background: repeating-conic-gradient(#ccc 0% 25%, transparent 0% 50%) 50% / 10px 10px;',
          ],
        ];

        $build['demo'][$demo_num]['item'][] = [
          '#type' => 'inline_template',
          '#template' => $component_source . "{{ attach_library('$library_id') }}",
          '#context' => $demo_data_item,
        ];
      }
    }
    else {
      $build = [
        '#markup' => '<h2>Component not found.</h2>',
      ];
    }

    return $build;
  }

}
