<?php

namespace Drupal\first_one\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class FirstOneController - practicing code.
 *
 * @package Drupal\first_one\Controller
 */
class FirstOneController extends ControllerBase {

  /**
   * Example method - display route list with their config name.
   *
   * @return array
   *  Returns data prepared for writeout.
   */
  public function parent() {
    $showRoutes = [
      'first_one.route_one',
      [
        'first_one.route_one_count',
        10,
      ],
      'first_one.route_content',
      'first_one.webform_count',
      'first_one.webform_tweak_count',
    ];

    return [
      '#theme' => 'parent_one',
      '#variable1' => 'First One Controller - The Parent Method Response.',
      '#variable2' => $showRoutes,
    ];
  }

  /**
   * Example method - display text and themes variables with default values.
   *
   * @return string[]
   *  Returns data prepared for writeout.
   */
  public function one() {
    return [
      '#theme' => 'first_one',
      '#variable1' => 'First One Controller - The One Method Response.',
    ];
  }

  /**
   * Example method - calling helper method for values.
   *
   * @param int $count
   *  GET parameter - number that will be used to create example logic.
   *
   * @return array
   *  Returns data prepared for writeout.
   */
  public function count(int $count) {
    $countArr = $this->countForMe($count);

    return [
      '#theme' => 'first_one_count',
      '#variable1' => 'First Module Controller - The Count Method Response',
      '#variable2' => $countArr[0],
      '#variable3' => [],
      '#variable4' => $countArr[1],
    ];
  }

  /**
   * Example method - using Webform for collecting data.
   *
   * @return array
   *  Returns webform prepared for output.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function countWebForm() {
    $webformMachinename = 'counting_parameter';
    $form = \Drupal::entityTypeManager()->getStorage('webform')->load($webformMachinename);
    $output = \Drupal::entityTypeManager()
      ->getViewBuilder('webform')
      ->view($form);

    return $output;
  }

  /**
   * Example method - using Webform for collecting data.
   * Render webform in twig using twig-tweak method.
   *
   * @return array
   *  Returns data prepared for writeout.
   */
  public function countWebFormTweak() {
    return [
      '#theme' => 'first_one_count_webf_tweak',
      '#variable1' => 'First Module Controller - The Webform using Tweak Method Response',
      '#variable3' => [],
    ];
  }

  /**
   * Helper method for counting some simple logic,
   * with code used in more than one method.
   *
   * @param int $count
   *  Method parameter - number that will be used to create example logic.
   *
   * @return array
   *  Returns calculated array.
   */
  public function countForMe(int $count) {
    $countTo = $out = NULL;
    if (is_numeric($count)) {
      if ($count > 0) {
        $out = "";
        $countTo = "Count to " . $count;
        for ($i = 0; $i < $count;) {
          $out .= ++$i;
          $out .= ($i < $count) ? " - " : "";
        }
      } elseif ($count == 0) {
        $countTo .= "Zero.";
        $out = $countTo;
      } elseif ($count < 0) {
        $countTo .= "Less than Zero.";
        $out = $countTo;
      }
    } else {
      $countTo .= "Not an number!";
      $out = $countTo;
    }

    $countArr = [];
    $countArr[] = $countTo;
    $countArr[] = $out;

    return $countArr;
  }

  /**
   * Example method - display text and themes variables with predefined values.
   *
   * @return array
   */
  public function content() {
    $myText = 'This is not just a default text!';
    $myNumber = 1;
    $myArray = [1, 2, 3];

    return [
      '#theme' => 'first_one',
      '#variable1' => $myText,
      '#variable2' => $myNumber,
      '#variable3' => $myArray,
    ];
  }

}
