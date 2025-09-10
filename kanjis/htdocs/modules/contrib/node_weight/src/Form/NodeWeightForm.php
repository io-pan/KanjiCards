<?php

namespace Drupal\node_weight\Form;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Component\Utility\DeprecationHelper;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Utility\Error;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Node Weight configuration form.
 */
class NodeWeightForm extends ConfigFormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactory $config_factory
   *   The config factory.
   * @param \Drupal\Core\Config\TypedConfigManagerInterface $typedConfigManager
   *   The typed config manager.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(
    ConfigFactory $config_factory,
    protected TypedConfigManagerInterface $typedConfigManager,
    EntityTypeManagerInterface $entity_type_manager
  ) {
    parent::__construct($config_factory, $typedConfigManager);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('config.typed'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'node_weight_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('node_weight.settings');

    // Get available node types.
    $node_types = $this->entityTypeManager->getStorage('node_type')->loadMultiple();
    $options = [];
    foreach ($node_types as $node_type) {
      $options[$node_type->id()] = $node_type->label();
    }

    // Node types checkboxes.
    $form['checked_node_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Available on'),
      '#description' => $this->t('The node types to toggle node weight on.'),
      '#default_value' => $config->get('node_weight.checked_node_types') ?: [],
      '#options' => $options,
    ];

    $form['min_weight'] = [
      '#type' => 'number',
      '#title' => $this->t('Minimum Weight'),
      '#description' => $this->t('Specify the minimum value for the weight field. This is the lowest weight that can be assigned to a node.'),
      '#default_value' => $config->get('node_weight.min_weight') ?: -10,
    ];

    $form['max_weight'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum Weight'),
      '#description' => $this->t('Specify the maximum value for the weight field. This is the highest weight that can be assigned to a node.'),
      '#default_value' => $config->get('node_weight.max_weight') ?: 10,
    ];

    $form['include_unpublished'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Include Unpublished Nodes'),
      '#description' => $this->t('The toggle option for including unpublished nodes.'),
      '#default_value' => $config->get('node_weight.include_unpublished'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $min_weight = $form_state->getValue('min_weight');
    $max_weight = $form_state->getValue('max_weight');

    if (($min_weight > $max_weight) || ($min_weight == $max_weight)) {
      $form_state->setErrorByName('min_weight', $this->t('Minimum Weight must be less than Maximum Weight.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('node_weight.settings');
    $config->set('node_weight.checked_node_types', array_filter(array_values($form_state->getValue('checked_node_types'))));
    $config->set('node_weight.min_weight', $form_state->getValue('min_weight'));
    $config->set('node_weight.max_weight', $form_state->getValue('max_weight'));
    $config->set('node_weight.include_unpublished', $form_state->getValue('include_unpublished'));
    $config->save();

    foreach ($form_state->getValue('checked_node_types') as $node_type_key => $node_type) {
      if ($node_type) {
        try {
          node_weight_create_field_node_weight($node_type);
        }
        catch (InvalidPluginDefinitionException | PluginNotFoundException | EntityStorageException $e) {
          DeprecationHelper::backwardsCompatibleCall(\Drupal::VERSION, '10.1.0', fn() => Error::logException(\Drupal::logger('node_weight'), $e), fn() => watchdog_exception('node_weight', $e));
        }
      }
      else {
        node_weight_delete_field_node_weight($node_type_key);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'node_weight.settings',
    ];
  }

}
