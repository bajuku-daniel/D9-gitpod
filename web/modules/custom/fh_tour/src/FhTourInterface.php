<?php

namespace Drupal\fh_tour;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a fh tour entity type.
 */
interface FhTourInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the fh tour title.
   *
   * @return string
   *   Title of the fh tour.
   */
  public function getTitle();

  /**
   * Sets the fh tour title.
   *
   * @param string $title
   *   The fh tour title.
   *
   * @return \Drupal\fh_tour\FhtourInterface
   *   The called fh tour entity.
   */
  public function setTitle($title);

  /**
   * Gets the fh tour creation timestamp.
   *
   * @return int
   *   Creation timestamp of the fh tour.
   */
  public function getCreatedTime();

  /**
   * Sets the fh tour creation timestamp.
   *
   * @param int $timestamp
   *   The fh tour creation timestamp.
   *
   * @return \Drupal\fh_tour\FhTourInterface
   *   The called fh tour entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the fh tour status.
   *
   * @return bool
   *   TRUE if the fh tour is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the fh tour status.
   *
   * @param bool $status
   *   TRUE to enable this fh tour, FALSE to disable.
   *
   * @return \Drupal\fh_tour\FhTourInterface
   *   The called fh tour entity.
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
