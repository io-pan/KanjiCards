<?php

namespace Drupal\print\Form;

use Drupal\Component\Utility\DeprecationHelper;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Asset\LibraryDiscoveryInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\DependencyInjection\AutowireTrait;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a form that configures print settings.
 */
class SettingsForm extends ConfigFormBase {

  use AutowireTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    TypedConfigManagerInterface $typed_config_manager,
    protected LibraryDiscoveryInterface $libraryDiscovery,
  ) {
    parent::__construct($config_factory, $typed_config_manager);
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'print_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'print_settings.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get current settings.
    $print_config = $this->config('print_settings.settings');

    // Load the print libraries so we can use its definitions here.
    $print_library = $this->libraryDiscovery->getLibraryByName('print_settings', 'print.svg');

    $form['marginT'] = [
      '#type' => 'number',
      '#title' => $this->t('printer margin top (mm)'),
      '#default_value' => $print_config->get('marginT')
      ];
    $form['marginB'] = [
      '#type' => 'number',
      '#title' => $this->t('printer margin bottom (mm)'),
      '#default_value' => $print_config->get('marginB')
      
    ];
    $form['marginW'] = [
      '#type' => 'number',
      '#title' => $this->t('printer margin width (mm)'),
      '#default_value' => $print_config->get('marginW')
    ];

    $form['versoOffsetY'] = [
      '#type' => 'number',
      '#title' => $this->t('printer offset Y for verso (mm)'),
      '#default_value' => $print_config->get('versoOffsetY')
    ];
    $form['versoOffsetX'] = [
      '#type' => 'number',
      '#title' => $this->t('printer offset X for verso (mm)'),
      '#default_value' => $print_config->get('versoOffsetX')
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
return true;
    // Validate URL.
    if (!empty($values['print_external_location']) && !UrlHelper::isValid($values['print_external_location'])) {
      $form_state->setErrorByName('print_external_location', $this->t('Invalid external library location.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();


    // Save the updated settings.
    $this->config('print.settings')
      ->set('marginT', $values['marginT'])
      ->set('marginB', $values['marginB'])
      ->set('marginW', $values['marginW'])
      ->set('versoOffsetY', $values['versoOffsetY'])
      ->set('versoOffsetX', $values['versoOffsetX'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
