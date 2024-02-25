<?php

namespace Drupal\productsHandler\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Exception;

class ProductContentService {

  use StringTranslationTrait;

  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Construct the service.
   *
   * @param EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Get the content for a product type.
   *
   * @param string $product_type
   *   The product type.
   *
   * @return array
   *   The render array.
   */
  public function getContent(string $product_type): array {
    try {
      $node = $this->entityTypeManager
        ->getStorage('node')
        ->loadByProperties(['type' => 'guitare-electrique', 'title' => $product_type]);

      if ($node) {
        // Build a render array for the node.
        return $this->entityTypeManager
          ->getViewBuilder('node')
          ->view(reset($node)); // Get the first node if multiple nodes found.
      }
      else {
        return ['#markup' => $this->t('Product not found.')];
      }
    }
    catch (Exception $e) {
      // Log or handle the exception.
      return ['#markup' => $this->t('An error occurred.' . $e->getMessage())];
    }
  }

}
