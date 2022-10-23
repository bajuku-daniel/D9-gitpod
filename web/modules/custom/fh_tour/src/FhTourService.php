<?php

namespace Drupal\fh_tour;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\field\Entity\FieldStorageConfig;


/**
 * Class FhTourService
 *
 * Handles search request for Tour and Sights
 *
 */
class FhTourService implements FhTourServiceInterface {

  public function __construct() {

  }

  public function getUserTours() {

    $currentUser = \Drupal::currentUser();
    $query = \Drupal::entityQuery('fh_tour');
    $query->condition('uid', $currentUser->id());

    $author_tour_ids=$query->execute();

    return $author_tour_ids;
  }

  public function checkSightIsInTour($tour, $sight_id) {

    $sights = $tour->get('sights')->referencedEntities();
    $ids = [];
    foreach ($sights as $sight){
      $id = $sight->id();
      $ids[$id] = ($id === $sight_id ? TRUE : FALSE);
      if ($id === $sight_id) {
        return true;
      }
    }
    return FALSE;
  }
}
