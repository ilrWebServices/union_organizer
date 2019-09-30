<?php

namespace Drupal\union_organizer\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * Configurable Union section layout.
 */
class CuSectionLayout extends LayoutDefault implements PluginFormInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'full_width' => FALSE,
      'extra_classes' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();

    $form['full_width'] = array(
      '#title' => t('Full width'),
      '#type' => 'checkbox',
      '#description' => t('Allow section to fill the container width.'),
      '#default_value' => $configuration['full_width'],
    );

    $form['extra_classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Extra classes'),
      '#description' => t('Additional css classes for this section.'),
      '#default_value' => $configuration['extra_classes'],
    ];
    return $form;
  }

  /**
   * @inheritdoc
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    // This abstract method required by PluginFormInterface
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['full_width'] = $form_state->getValue('full_width');
    $this->configuration['extra_classes'] = $form_state->getValue('extra_classes');
  }

}
