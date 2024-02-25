<?php

namespace Drupal\productsHandler\Controller;

use AllowDynamicProperties;
use Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\AutowireTrait;
use Drupal\productsHandler\Service\ProductContentService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Controller for the Products page.
 */
#[AllowDynamicProperties] class ProductsController extends ControllerBase {

  protected string $product;

  protected LoggerInterface $logger;

  /**
   * Construct the controller.
   *
   * @param string $product_type
   * @param \Drupal\productsHandler\Service\ProductContentService $productContentService
   */
  public function __construct(string $product_type, ProductContentService $productContentService) {
    $this->product = $product_type;
    $this->productContentService = $productContentService;
    $this->logger = Drupal::logger('productsHandler');
    $this->logger->debug('Product type received: @product_type', ['@product_type' => $this->product]);
  }

  /**
   * Create the controller.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   *
   * @return \Drupal\productsHandler\Controller\ProductsController|\Drupal\Core\DependencyInjection\AutowireTrait The
   *   controller. The controller.
   */
  public static function create(ContainerInterface $container): ProductsController|AutowireTrait|static {
    return new static(
      $container->get('current_route_match')->getParameter('product_type'),
      $container->get('productsHandler.service.productContent')
    );
  }

  /**
   * Display the content for the Products page.
   */
  public function content(string $product_type): array {
    Drupal::logger('productsHandler')
      ->debug('Controller content method executed.');
    $content = $this->productContentService->getContent($product_type);
    Drupal::logger('productsHandler')
      ->debug('Service method invoked with result: @result', ['@result' => print_r($content, TRUE)]);

    if ($content) {
      return $content;
    }
    else {
      // Handle the case when the product content is not found.
      return [
        '#markup' => $this->t('Product content not found.'),
      ];
    }
  }

}
