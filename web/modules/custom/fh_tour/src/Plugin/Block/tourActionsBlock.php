<?php
/**
 * @file
 * Contains \Drupal\fh_tour\Plugin\Block\tourActionsBlock.
 */

namespace Drupal\fh_tour\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;

/**
 * Provides a 'tour_actions' Block
 *
 * @Block(
 *   id = "tour_actions",
 *   admin_label = @Translation("Tour Actions"),
 * )
 */
class tourActionsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $sight = \Drupal::routeMatch()->getParameter('fh_sight');
    $sight_id = $sight->id();
    $link_options = ['absolute' => TRUE];
    $link_url = Url::fromRoute('fh_tour.action.modal',['entity_id' => $sight_id],  $link_options);
    $link_url->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'btn', 'btn-primary'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode(['width' => 400]),
      ]
    ]);

    return array(
      '#type' => 'markup',
      '#markup' => Link::fromTextAndUrl(t('Zur Tour Hinzufügen'), $link_url)->toString(),
      '#attached' => ['library' => ['core/drupal.dialog.ajax']]
    );
  }
}
