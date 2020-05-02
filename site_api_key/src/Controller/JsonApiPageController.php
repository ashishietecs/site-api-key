<?php

namespace Drupal\site_api_key\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;

/**
 * Class JsonApiPageController
 * @package Drupal\site_api_key\Controller
 */
class JsonApiPageController extends ControllerBase {

  /**
   * @return JsonResponse
   */
  public function index($sitekey = null , $nodeid = null) {

    return new JsonResponse([ 'data' => $this->getData($nodeid), 'method' => 'GET', 'status'=> 200]);

  }

  /**
   * @return array
   */
  public function getData($nodeid) {

    //Loading entity object using entitytypemanager 
    $entity = $this->entityTypeManager()->getStorage('node')->load($nodeid);
    return $entity->toArray();

  }

  /**
  * Checks access for this controller.
  */
  public function access($sitekey = null , $nodeid = null) {

    //Getting configuration object
    $config = $this->config('system.site');
    $siteapikey = $config->get('siteapikey');
    // Using the storage controller
    $entity = $this->entityTypeManager()->getStorage('node')->load($nodeid);
    // Make sure that an object is an entity.
    if ($entity instanceof \Drupal\Core\Entity\EntityInterface) {

      // Get the bundle.
      $bundletype = $entity->bundle();
      if(($sitekey == $siteapikey) && !empty($siteapikey) && ($bundletype == "page")) {

        // Return allowed.  
        return AccessResult::allowed();
      }else {

        // Return 403 Access Denied page.  
        return AccessResult::forbidden();
      }

    }else {

      // Return 403 Access Denied page.  
      return AccessResult::forbidden();
    }  
  }
}