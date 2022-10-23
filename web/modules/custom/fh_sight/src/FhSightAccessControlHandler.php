<?php

namespace Drupal\fh_sight;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the fh sight entity type.
 */
class FhSightAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view fh sight');

      case 'update':
        return AccessResult::allowedIfHasPermissions($account, ['edit fh sight', 'administer fh sight'], 'OR');

      case 'delete':
        return AccessResult::allowedIfHasPermissions($account, ['delete fh sight', 'administer fh sight'], 'OR');

      default:
        // No opinion.
        return AccessResult::neutral();
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions($account, ['create fh sight', 'administer fh sight'], 'OR');
  }

}
