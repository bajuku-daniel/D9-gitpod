<?php

namespace Drupal\fh_sight\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Configuration form for a fh sight entity type.
 */
class FhSightSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'fh_sight_settings';
  }

  public function getEditableConfigNames()
  {
    return [
      'fh_sight.settings',
    ];
  }

   /**
   * {@inheritdoc}
   */
  public function buildForm($form, FormStateInterface $form_state) {
    $config = $this->config('fh_sight.settings');

    $form['fh_sight_settings'] = [
      '#markup' => $this->t('<h1>FH SIGHT ADMINISTRATION</h1>'),
    ];

    $form['fh_sight_settings']['sight_year_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable the Display of the Year input Field'),
      '#default_value' => $config->get('year_enabled'),
    ];

    $form['fh_sight_settings']['sight_categories'] = [
      '#type' => 'textarea',
      '#title' => $this->t('List of Sight Categories'),
      '#description' => $this->t('List of Sight Categories'),
      '#default_value' => $config->get('sight_categories'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return parent::buildForm($form, $form_state);  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('fh_sight.settings');
    $config->set('year_enabled', $form_state->getValue('sight_year_enabled'));
    $config->set('sight_categories', $form_state->getValue('sight_categories'));
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
