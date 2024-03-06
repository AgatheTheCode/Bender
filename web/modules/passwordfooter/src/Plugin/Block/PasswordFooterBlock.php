<?php declare(strict_types = 1);

namespace Drupal\passwordfooter\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a password footer block.
 *
 * @Block(
 *   id = "passwordfooter_password_footer",
 *   admin_label = @Translation("Password Footer"),
 *   category = @Translation("Custom"),
 * )
 */
final class PasswordFooterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'login' => 'default_login',
      'password' => 'default_password',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $form['login'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Login'),
      '#default_value' => $this->configuration['login'],
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#default_value' => $this->configuration['password'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $this->configuration['login'] = $form_state->getValue('login');
    $this->configuration['password'] = $form_state->getValue('password');
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['content'] = [
      '#markup' => $this->t('Login: @login <br> Password: @password', [
        '@login' => $this->configuration['login'],
        '@password' => $this->configuration['password'],
      ]),
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account): AccessResult {
    // Autoriser toujours l'accès.
    return AccessResult::allowed();
  }

}
