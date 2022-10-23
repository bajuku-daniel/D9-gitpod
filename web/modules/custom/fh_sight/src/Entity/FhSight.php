<?php

namespace Drupal\fh_sight\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\fh_sight\FhSightInterface;
use Drupal\user\UserInterface;

/**
 * Defines the fh sight entity class.
 *
 * @ContentEntityType(
 *   id = "fh_sight",
 *   label = @Translation("FH Sight"),
 *   label_collection = @Translation("FH Sights"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\fh_sight\FhSightListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\fh_sight\FhSightAccessControlHandler",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler",
 *     "form" = {
 *       "default" = "Drupal\fh_sight\Form\FhSightForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "fh_sight",
 *   data_table = "fh_sight_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer fh sight",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "title",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/fh-sight/add",
 *     "canonical" = "/fh_sight/{fh_sight}",
 *     "edit-form" = "/fh-sight/{fh_sight}/edit",
 *     "delete-form" = "/fh-sight/{fh_sight}/delete",
 *     "collection" = "/admin/fh-sight"
 *   },
 *   field_ui_base_route = "entity.fh_sight.settings"
 * )
 */
class FhSight extends ContentEntityBase implements FhSightInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new fh sight entity is created, set the uid entity reference to
   * the current user as the creator of the entity.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += ['uid' => \Drupal::currentUser()->id()];
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title) {
    $this->set('title', $title);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled() {
    return (bool) $this->get('status')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus($status) {
    $this->set('status', $status);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    /*
     * Global FH Sight Fields
     * Valid for Main and Overlay Image
     */

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setTranslatable(TRUE)
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the fh sight entity.'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['teaser'] = BaseFieldDefinition::create('string')
      ->setTranslatable(TRUE)
      ->setLabel(t('Teaser'))
      ->setDescription(t('The Teaser of the fh sight entity.'))
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setTranslatable(TRUE)
      ->setLabel(t('Description'))
      ->setDescription(t('The Description of the fh sight entity.'))
      ->setDisplayOptions('form', [
        'type' => 'text_format',
        'weight' => 3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['year_show'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Show Year'))
      ->setDescription(t('A boolean indicating to show the main year or not.'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Show Year')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['year_accuracy'] = BaseFieldDefinition::create('list_string')
      ->setRequired(TRUE)
      ->setLabel(t('Year Accuracy'))
      ->setDescription(t('What is the accuracy of the Years'))
      ->setDefaultValue('accurately')
      ->setSettings([
        'allowed_values' =>
          [
            'accurately' => t('Accurately'),
            'inaccurately' => t('Inaccurately')
          ]
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['category'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Sight Category'))
      ->setDescription(t('The Category of the Sight.'))
      ->setCardinality(-1)
      ->setSetting('allowed_values_function', 'fh_sight_category_allowed_values_function')
      ->setDisplayOptions('form', [
        'type' => 'options_buttons',
        'weight' => 6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['audio'] = BaseFieldDefinition::create('file')
      ->setLabel(t('Audio'))
      ->setDescription(t('The audio File, mp3 25mb'))
      ->setSettings([
        'uri_scheme' => 'public',
        'file_directory' => 'sight-audios',
        'file_extensions' => 'mp3',
        'max_filesize' => '25000 KB',
      ])
      ->setDisplayOptions('form', [
        'type'    => 'file',
        'weight'  => 7,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['video'] = BaseFieldDefinition::create('file')
      ->setLabel(t('Video'))
      ->setDescription(t('The video File, mp4 25mb'))
      ->setSettings([
        'uri_scheme' => 'public',
        'file_directory' => 'sight-videos',
        'file_extensions' => 'mp4',
        'max_filesize' => '25000 KB',
      ])
      ->setDisplayOptions('form', [
        'type'    => 'file',
        'weight'  => 8,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    /*
     * Space for TAGS Field
     * todo: entity reference field for Tags
     */

    /*
     * MAIN IMAGE
     */
    $fields['main_image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Main Image'))
      ->setDescription(t('The Main Image of the fh sight entity.'))
      ->setCardinality(1)
      ->setSettings([
        'rename' => 'smi',
        'file_directory' => 'sight-main-images',
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => '5000 KB',
        'max_resolution' => '4000x4000',
        'min_resolution' => '400x400',
        'alt_field' => false,
        'alt_field_required' => false,
        'title_field' => false,
        'title_field_required' => false,
      ])
      ->setDisplayOptions('form', [
        'type'    => 'image_image',
        'weight'  => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['main_image_year'] = BaseFieldDefinition::create('integer')
      ->setTranslatable(FALSE)
      ->setLabel(t('Main Year'))
      ->setDescription(t('The Year of the Main Image'))
      ->setRequired(FALSE)
      ->setSettings(['min' => -999, 'max' => 2050])
      ->setDisplayOptions('form', [
        'weight' => 11,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['main_image_license'] = BaseFieldDefinition::create('list_string')
      ->setRequired(TRUE)
      ->setLabel(t('License of the main Image'))
      ->setDescription(t('What is the License of the main Image'))
      ->setDefaultValue('1')
      ->setSettings([
        'allowed_values' =>
          [
            '1' => t('Unrestricted right of use (public domain) '),
            '2' => t('Creative Commons BY'),
            '3' => t('Creative Commons BY-SA'),
            '4' => t('Creative Commons BY-SA-NC'),
            '5' => t('Creative Commons BY-ND'),
            '6' => t('All rights reserved'),
          ]
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 12,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['main_image_source'] = BaseFieldDefinition::create('string')
      ->setTranslatable(FALSE)
      ->setLabel(t('Source of the main Image'))
      ->setDescription(t('The Source of the main Image.'))
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 13,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['main_image_source_url'] = BaseFieldDefinition::create('string')
      ->setTranslatable(FALSE)
      ->setLabel(t('Source URL of the main Image'))
      ->setDescription(t('The Source URL of the main Image.'))
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 14,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['main_image_author'] = BaseFieldDefinition::create('string')
      ->setTranslatable(FALSE)
      ->setLabel(t('Author of the main Image'))
      ->setDescription(t('The Author of the main Image.'))
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    /*
    * OVERLAY IMAGE
    */
    $fields['overlay_image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Overlay Image'))
      ->setDescription(t('The Overlay Image of the fh sight entity.'))
      ->setSettings([
        'uri_scheme' => 'public',
        'file_directory' => 'sight-overlay-images',
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => '5000 KB',
        'max_resolution' => '4000x4000',
        'min_resolution' => '400x400',
        'alt_field' => false,
        'alt_field_required' => false,
        'title_field' => false,
        'title_field_required' => false,
      ])
      ->setDisplayOptions('form', [
        'type'    => 'image_image',
        'weight'  => 30,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['overlay_image_year'] = BaseFieldDefinition::create('integer')
      ->setTranslatable(FALSE)
      ->setLabel(t('Overlay Image Year'))
      ->setDescription(t('The Year of the overlay Image'))
      ->setRequired(FALSE)
      ->setSettings(['min' => -999, 'max' => 2050])
      ->setDisplayOptions('form', [
        'weight' => 31,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['overlay_image_license'] = BaseFieldDefinition::create('list_string')
      ->setRequired(TRUE)
      ->setLabel(t('License of the overlay Image'))
      ->setDescription(t('What is the License of the overlay Image'))
      ->setDefaultValue('1')
      ->setSettings([
        'allowed_values' =>
          [
            '1' => t('Unrestricted right of use (public domain) '),
            '2' => t('Creative Commons BY'),
            '3' => t('Creative Commons BY-SA'),
            '4' => t('Creative Commons BY-SA-NC'),
            '5' => t('Creative Commons BY-ND'),
            '6' => t('All rights reserved'),
          ]
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 32,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['overlay_image_source'] = BaseFieldDefinition::create('string')
      ->setTranslatable(FALSE)
      ->setLabel(t('Source of the overlay Image'))
      ->setDescription(t('The Source of the overlay Image.'))
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 33,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['overlay_image_source_url'] = BaseFieldDefinition::create('string')
      ->setTranslatable(FALSE)
      ->setLabel(t('Source URL of the overlay Image'))
      ->setDescription(t('The Source URL of the overlay Image.'))
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 34,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['overlay_image_author'] = BaseFieldDefinition::create('string')
      ->setTranslatable(FALSE)
      ->setLabel(t('Author of the overlay Image'))
      ->setDescription(t('The Author of the overlay Image.'))
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 35,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    /*
     * FH SIGHT POSITION FIELDS
     */
    $fields['position_lat'] = BaseFieldDefinition::create('float')
      ->setTranslatable(FALSE)
      ->setLabel(t('Position LAT'))
      ->setDisplayOptions('form', [
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['position_lng'] = BaseFieldDefinition::create('float')
      ->setTranslatable(FALSE)
      ->setLabel(t('Position LNG'))
      ->setDisplayOptions('form', [
        'weight' => 21,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['position_angle'] = BaseFieldDefinition::create('float')
      ->setTranslatable(FALSE)
      ->setLabel(t('Position Angle'))
      ->setDisplayOptions('form', [
        'weight' => 22,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['position_view_direction'] = BaseFieldDefinition::create('float')
      ->setTranslatable(FALSE)
      ->setLabel(t('Position View Direction'))
      ->setDisplayOptions('form', [
        'weight' => 23,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['position_distance'] = BaseFieldDefinition::create('float')
      ->setTranslatable(FALSE)
      ->setLabel(t('Position Distance'))
      ->setDisplayOptions('form', [
        'weight' => 24,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['position_city'] = BaseFieldDefinition::create('string')
      ->setTranslatable(FALSE)
      ->setLabel(t('Position City'))
      ->setSetting('max_length', 60)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 25,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    // Base Fields
    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDescription(t('A boolean indicating whether the fh sight is enabled.'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Published')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 80,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setTranslatable(TRUE)
      ->setLabel(t('Author'))
      ->setDescription(t('The user ID of the fh sight author.'))
      ->setSetting('target_type', 'user')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 81,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the fh sight was created.'))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 82,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the fh sight was last edited.'));

    return $fields;
  }

}
