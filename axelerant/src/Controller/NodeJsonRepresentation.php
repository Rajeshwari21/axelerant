<?php

namespace Drupal\axelerant\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PromocodeApprove.
 *
 * @package Drupal\axelerant\Controller
 */
class NodeJsonRepresentation extends ControllerBase {

  /**
   * Return JSON Response of the node.
   */
  public function content($api_key, $nid) {
    if (!empty($nid)) {
      $node = Node::load($nid);
      $node_array = $node->toArray();
      return new JsonResponse($node_array, 200, ['Content-Type'=> 'application/json']);
    }
  }
}
