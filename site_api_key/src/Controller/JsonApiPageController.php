<?php

namespace Drupal\site_api_key\Controller;

use Drupal\Core\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;

/**
 * Class JsonApiPageController.
 *
 * @package Drupal\site_api_key\Controller
 */
class JsonApiPageController extends ControllerBase {

  /**
   * Returning JsonResponse.
   */
  public function index($sitekey = NULL, $nodeid = NULL) {

    return new JsonResponse(
      ['data' => $this->getData($nodeid), 'method' => 'GET', 'status' => 200]);

  }

  /**
   * Rereturning array of given node object.
   */
  public function getData($nodeid) {

    // Loading entity object using entitytypemanager.
    $entity = $this->entityTypeManager()->getStorage('node')->load($nodeid);
    return $entity->toArray();

  }

  /**
   * Checks access for this controller.
   */
  public function access($sitekey = NULL, $nodeid = NULL) {

    // Getting configuration object.
    $config = $this->config('system.site');
    $siteapikey = $config->get('siteapikey');
    // Using the storage controller.
    $entity = $this->entityTypeManager()->getStorage('node')->load($nodeid);
    // Make sure that an object is an entity.
    if ($entity instanceof EntityInterface) {

      // Get the bundle.
      $bundletype = $entity->bundle();
      if (($sitekey == $siteapikey) && !empty($siteapikey) && ($bundletype == "page")) {

        // Return allowed.
        return AccessResult::allowed();
      }
      else {

        // Return 403 Access Denied page.
        return AccessResult::forbidden();
      }

    }
    else {

      // Return 403 Access Denied page.
      return AccessResult::forbidden();
    }
  }

}
