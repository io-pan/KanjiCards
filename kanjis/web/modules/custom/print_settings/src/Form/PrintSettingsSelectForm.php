<?php
namespace Drupal\print_settings\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Formulaire de sélection d'une imprimante.
 */
class PrintSettingsSelectForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'print_settings_select_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $options = [];

    // Récupérer toutes les entités config d’imprimante.
    $imprimantes = \Drupal::entityTypeManager()
      ->getStorage('print_settings')
      ->loadMultiple();

    foreach ($imprimantes as $id => $imprimante) {
      $options[$id] = $imprimante->label();
    }

    $session = \Drupal::request()->getSession();
    $selected = $session->get('imprimante_selectionnee');

    $form['imprimante'] = [
      '#type' => 'select',
      '#title' => $this->t('Choisissez une imprimante'),
      '#options' => $options,
      '#default_value' => $selected,
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Appliquer'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $imprimante_id = $form_state->getValue('imprimante');
    $session = \Drupal::request()->getSession();
    $session->set('imprimante_selectionnee', $imprimante_id);

    // $this->messenger()->addStatus($this->t("L'imprimante '@printer' a été sélectionnée.", [
    //   '@printer' => $imprimante_id,
    // ]));

    // Rediriger vers la même page pour recharger la vue avec les marges.
    $form_state->setRedirect('<current>');
  }

}