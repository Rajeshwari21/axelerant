<?php

namespace Drupal\axelerant\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the CustomNodeAccess controller.
 */
class CustomNodeAccess extends ControllerBase {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /*
   * Class constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   An instance of ConfigFactoryInterface.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * Checks access for this controller.
   */
  public function access($api_key, $nid) {
    // Access allowed if nid is of basic page & Site api key matches with the one added in site configuration form
    // else Access Denied.
    $siteapikey = $this->configFactory->get('site_api_key.settings')->get('siteapikey');
    $query = \Drupal::database()->select('node_field_data', 'n');
    $query->fields('n', ['nid']);
    $query->condition('n.nid', $nid);
    $query->condition('n.type', 'page');
    $page_nid = $query->execute()->fetchField();
    if ($siteapikey == $api_key && !empty($page_nid)) {
      return AccessResult::allowed();
    }
     return AccessResult::forbidden();
  }
}
