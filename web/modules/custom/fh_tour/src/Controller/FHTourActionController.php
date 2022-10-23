<?php

/**
 * @file
 * FHTourActionController class.
 */

namespace Drupal\fh_tour\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\fh_tour\FhTourService;
use Drupal\fh_tour\FhTourServiceInterface;
use Drupal\Core\Ajax\ReplaceCommand;

class FHTourActionController extends ControllerBase {

  public function actionModal($entity_id) {

    $fh_tour_actions = new FhTourService();
    $user_tours = $fh_tour_actions->getUserTours();

    $add_link = '/fh-tour/new/' . $entity_id;
    if (empty($user_tours)) {
      $modal_data = '<p>Es ist noch keine Tour vorhanden, bitte neue erstellen:<br><a href="' . $add_link . '">Neue Tour mit dieser Ansicht erstellen</a></p>';
    }
    else {
      $modal_data = '';

      foreach ($user_tours as $tour_id) {
        $tour_storage = \Drupal::entityTypeManager()->getStorage('fh_tour');
        $tour = $tour_storage->load($tour_id);
        $tour_title = $tour->title->value;

        if ($fh_tour_actions->checkSightIsInTour($tour, $entity_id)) {
          $modal_data = $modal_data . $tour_title . ' <div class="tour_action_link" id="' . $tour_id . '"><a class="use-ajax" href="/fh-tour/ajax/actionRemove/' . $entity_id . '/' . $tour_id . '">Remove</a></div><br>';
        }
        else {
          $modal_data = $modal_data . $tour_title . ' <div class="tour_action_link" id="' . $tour_id . '"><a class="use-ajax" href="/fh-tour/ajax/actionAdd/' . $entity_id . '/' . $tour_id . '">Add</a></div><br>';
        }
      }
      $modal_data = $modal_data . '<p><a href="' . $add_link . '">Neue Tour mit dieser Ansicht erstellen</a></p>';
    }

    $options = [
      'dialogClass' => 'popup-dialog-class',
      'width' => '50%',
    ];

    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand(t('Neue Tour anlegen oder zu bestehender Tour hinzufügen'), $modal_data, $options));

    return $response;
  }

  public function actionAdd($entity_id, $tour_id) {

    $entity_storage = \Drupal::entityTypeManager()->getStorage('fh_tour');
    $entity = $entity_storage->load($tour_id);

    $entity->get('sights')->appendItem([
      'target_id' => $entity_id,
    ]);
    $entity->save();

    $response = new AjaxResponse();
    $Selector = '#' . $tour_id;
    $content = '<div class="tour_action_link" id="' . $tour_id . '"><a class="use-ajax" href="/fh-tour/ajax/actionRemove/' . $entity_id . '/' . $tour_id . '">ENTFERNEN</a></div>';
    $response->addCommand(new ReplaceCommand($Selector, $content));
    return $response;

  }

  public function actionRemove($entity_id, $tour_id) {

    $entity_storage = \Drupal::entityTypeManager()->getStorage('fh_tour');
    $entity = $entity_storage->load($tour_id);

    foreach ($entity->get('sights') as $delta => $field_item) {
      if ($field_item->target_id == $entity_id) {
        $entity->get('sights')->removeItem($delta);
        $entity->save();
        break;
      }
    }

    $response = new AjaxResponse();
    $Selector = '#' . $tour_id;
    $content = '<div class="tour_action_link" id="' . $tour_id . '"><a class="use-ajax" href="/fh-tour/ajax/actionAdd/' . $entity_id . '/' . $tour_id . '">HINZUFÜGEN</a></div>';
    $response->addCommand(new ReplaceCommand($Selector, $content));
    return $response;
  }

}
