<?php

namespace Drupal\fh_tour;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the fh tour entity type.
 */
class FhTourAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view fh tour');

      case 'update':
        return AccessResult::allowedIfHasPermissions($account, ['edit fh tour', 'administer fh tour'], 'OR');

      case 'delete':
        return AccessResult::allowedIfHasPermissions($account, ['delete fh tour', 'administer fh tour'], 'OR');

      default:
        // No opinion.
        return AccessResult::neutral();
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions($account, ['create fh tour', 'administer fh tour'], 'OR');
  }

}
