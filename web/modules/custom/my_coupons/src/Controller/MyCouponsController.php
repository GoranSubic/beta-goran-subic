<?php

declare(strict_types = 1);

namespace Drupal\my_coupons\Controller;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\node\NodeStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class that provides method for coupons listing.
 */
final class MyCouponsController extends ControllerBase {

  /**
   * The node storage.
   *
   * @var \Drupal\node\NodeStorageInterface
   */
  private $nodeStorage;

  /**
   * Class constructor.
   *
   * @param \Drupal\node\NodeStorageInterface $nodeStorage
   *   The node storage.
   */
  public function __construct(NodeStorageInterface $nodeStorage) {
    $this->nodeStorage = $nodeStorage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('entity_type.manager')->getStorage('node')
    );
  }

  /**
   * Method to list coupons for authenticated user.
   *
   * List every coupon if admin is logged in.
   *
   * @return string[]
   */
  public function index(): array {
    $query = $this->nodeStorage->getQuery();
    // Need all nodes so have to intentionally disable the access check on the query.
    $query->accessCheck(FALSE);
    $query->condition('type', 'coupon');
    $nIds = $query->execute();
    $nodes = $this->nodeStorage->loadMultiple($nIds);

    $build = [];
    $cacheability = CacheableMetadata::createFromRenderArray($build);

    $items = [];
    foreach ($nodes as $key => $node) {
      $coupon_access = $node->access('view', NULL, TRUE);
      // Collect the cacheability information regardless of whether the access result is allowed or denied.
      $cacheability->addCacheableDependency($coupon_access);

      if (
        $coupon_access->isAllowed() &&
        in_array($this->currentUser()->id(), array_column($node->get('field_user_access')->getValue(), 'target_id'))
      ) {
        $linkLabel = Link::createFromRoute($node->label(), 'entity.node.canonical', ['node' => $node->id()]);

        $items[] = [
          [
            '#markup' => $linkLabel->toString(),
          ],
          [
            '#markup' => $node->get('field_code')->getValue()[0]['value'],
            '#prefix' => '<div>',
            '#suffix' => '</div>',
          ]
        ];

        $cacheability->addCacheableDependency($node);
      }
    }

    if (!empty($items)) {
      $build['#theme'] = 'item_list';
      $build['#items'] = $items;
    } else {
      $build['#markup'] = t('No coupons are available.');
    }

    $build['#cache'] = [
      'context' => ['user'],
      'tags' => ['node_list'],
    ];

    $cacheability->applyTo($build);
    return $build;
  }

}
