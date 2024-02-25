<?php

namespace Drupal\productsHandler;

use Drupal\Core\Controller\ControllerBase;
use Drupal\productsHandler\Service\ProductContentService;

/**
 * Base class for product controllers.
 */
class ProductBase extends ControllerBase {

  protected ProductContentService $productContentService;

  /**
   * Constructs a new ProductBase object.
   *
   * @param \Drupal\productsHandler\Service\ProductContentService $productContentService
   *   The product content service.
   */
  public function __construct(ProductContentService $productContentService) {
    $this->productContentService = $productContentService;
  }

  /**
   * Display the content for the Products page.
   *
   * @param string $product_type
   *   The product type.
   *
   * @return array
   *   The render array.
   */
  public function content(string $product_type): array {
    return $this->productContentService->getContent($product_type);
  }

}
