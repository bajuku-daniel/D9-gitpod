<?php

namespace Drupal\fh_sight;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a fh sight entity type.
 */
interface FhSightInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the fh sight title.
   *
   * @return string
   *   Title of the fh sight.
   */
  public function getTitle();

  /**
   * Sets the fh sight title.
   *
   * @param string $title
   *   The fh sight title.
   *
   * @return \Drupal\fh_sight\FhSightInterface
   *   The called fh sight entity.
   */
  public function setTitle($title);

  /**
   * Gets the fh sight creation timestamp.
   *
   * @return int
   *   Creation timestamp of the fh sight.
   */
  public function getCreatedTime();

  /**
   * Sets the fh sight creation timestamp.
   *
   * @param int $timestamp
   *   The fh sight creation timestamp.
   *
   * @return \Drupal\fh_sight\FhSightInterface
   *   The called fh sight entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the fh sight status.
   *
   * @return bool
   *   TRUE if the fh sight is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the fh sight status.
   *
   * @param bool $status
   *   TRUE to enable this fh sight, FALSE to disable.
   *
   * @return \Drupal\fh_sight\FhSightInterface
   *   The called fh sight entity.
   */
  public function setStatus($status);

//
//  /**
//   * Extracts the allowed values array from the allowed_values  element.
//   *
//   * @param string $string
//   *   The raw string to extract values from.
//
//   * @return array|null
//   *   The array of extracted key/value pairs, or NULL if the string is invalid.
//   *
//   */
//  public function extractAllowedListValues($value_string);
}
