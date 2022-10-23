<?php

namespace Drupal\fh_tour\Form;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Core\Entity\EntityFieldManager;
use Drupal\Core\Field\Entity\BaseFieldOverride;


/**
 * Configuration form for a fh tour entity type.
 */
class FhTourSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'fh_tour_settings';
  }

  public function getEditableConfigNames()
  {
    return [
      'fh_tour.settings',
    ];
  }

   /**
   * {@inheritdoc}
   */
  public function buildForm($form, FormStateInterface $form_state) {
    $config = $this->config('fh_tour.settings');

    $form['fh_tour_settings'] = [
      '#markup' => $this->t('<h1>FH TOUR ADMINISTRATION</h1>'),
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
    $config = $this->config('fh_tour.settings');
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
