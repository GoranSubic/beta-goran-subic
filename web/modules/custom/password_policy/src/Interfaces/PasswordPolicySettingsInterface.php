<?php

declare(strict_types = 1);

namespace Drupal\password_policy\Interfaces;

/**
 * Interface for Password Policy settings.
 */
interface PasswordPolicySettingsInterface {

  public const MIN_CHARACTER_LENGTH = 'The password must be at least 8 characters long.';

  public const DIGIT_CHARACTERS = 'The password must include at least one digit (0-9).';

  public const LOWERCASED_CHARACTERS = 'The password must include at least one lower cased letter.';

  public const UPPERCASED_CHARACTERS = 'The password must include at least one upper cased letter.';

  public const SPECIAL_CHARACTERS = 'The password must include at least one special character.';

}
