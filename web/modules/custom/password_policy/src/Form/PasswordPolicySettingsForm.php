<?php

declare(strict_types = 1);

namespace Drupal\password_policy\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\password_policy\Interfaces\PasswordPolicySettingsInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A form for setting users password complexity.
 */
final class PasswordPolicySettingsForm extends ConfigFormBase implements PasswordPolicySettingsInterface {

  /**
   * Constructs a Password Policy form object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames(): array {
    return [
      'password_policy.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'password_policy_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form = parent::buildForm($form, $form_state);
    $configs = $this->config('password_policy.settings')->get();

    $defaultValue = [];
    foreach ($configs as $config => $value) {
      if ($value == TRUE) {
        $defaultValue[] = 'op_' . $config;
      }
    }

    $form['options'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Set Password Policy by checking options:'),
      '#options' => [
        'op_min_character_length' => PasswordPolicySettingsInterface::MIN_CHARACTER_LENGTH,
        'op_digit_characters' => PasswordPolicySettingsInterface::DIGIT_CHARACTERS,
        'op_lowercased_characters' => PasswordPolicySettingsInterface::LOWERCASED_CHARACTERS,
        'op_uppercased_characters' => PasswordPolicySettingsInterface::UPPERCASED_CHARACTERS,
        'op_special_characters' => PasswordPolicySettingsInterface::SPECIAL_CHARACTERS,
      ],
      '#default_value' => $defaultValue,
    ];
    $form['actions']['submit']['#value'] = $this->t('Change pass policy');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    parent::submitForm($form, $form_state);

    $this->config('password_policy.settings')
      ->set('min_character_length', $form_state->getValue('options')['op_min_character_length'])
      ->set('digit_characters', $form_state->getValue('options')['op_digit_characters'])
      ->set('lowercased_characters', $form_state->getValue('options')['op_lowercased_characters'])
      ->set('uppercased_characters', $form_state->getValue('options')['op_uppercased_characters'])
      ->set('special_characters', $form_state->getValue('options')['op_special_characters'])
      ->save();
  }

}
