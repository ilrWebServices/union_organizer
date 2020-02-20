<?php

namespace Drupal\union_organizer\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;

/**
 * Configurable Union default layout.
 */
class UnionLayoutGrid extends UnionLayoutDefault {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'grid_type' => '',
      'column_count' => 0,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();
    $form = parent::buildConfigurationForm($form, $form_state);
    $form['grid_type'] = [
      '#title' => t('Grid type'),
      '#type' => 'select',
      '#options' => [
        '2x1' => 'Two by one',
        '1x2' => 'One by two',
        'autogrid' => 'Auto-grid ▦',
      ],
      '#description' => t('The type of grid to use to flow the content.'),
      '#required' => TRUE,
      '#default_value' => $configuration['grid_type'],
    ];

    $form['autogrid_column_count'] = [
      '#title' => t('Auto-grid columns'),
      '#type' => 'number',
      '#min' => '2',
      '#max' => '4',
      '#states' => [
        'visible' => [
          ':select[name="grid_type"]' => ['value' => 'autogrid'],
        ],
      ],
      '#description' => t('Items in the grid automically flow across the number of columns. This setting is only applicable when auto-grid is selected as the type.'),
      '#default_value' => $configuration['autogrid_column_count'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['grid_type'] = $form_state->getValue('grid_type');
    $this->configuration['autogrid_column_count'] = $form_state->getValue('autogrid_column_count');
  }

}
