<?php

declare(strict_types = 1);

namespace Drupal\node_goto\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\NodeStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements an example form.
 */
final class NodeGotoForm extends FormBase {
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
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'node_goto_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['node_id'] = [
      '#type' => 'number',
      '#title' => $this->t('Node ID'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Go'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $nodeId = $form_state->getValue('node_id');
    $node = $this->nodeStorage->load($nodeId);

    if (empty($node)) {
      $form_state->setErrorByName('node_id', $this->t("The provided node ID @nid does not exist. Please enter a valid ID.", ['@nid' => $nodeId]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.node.canonical', ['node' => $form_state->getValue('node_id')]);
  }

}
