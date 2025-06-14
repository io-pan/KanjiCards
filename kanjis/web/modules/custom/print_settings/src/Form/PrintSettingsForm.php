<?php
namespace Drupal\print_settings\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

class PrintSettingsForm extends EntityForm {

  public function buildForm(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\print_settings\Entity\PrintSettings $entity */
    $entity = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#default_value' => $entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\print_settings\Entity\PrintSettings::load',
      ],
      '#disabled' => !$entity->isNew(),
    ];

    $form['pageH'] = [
      '#type' => 'number',
      '#title' => $this->t('hauteur de page (mm)'),
      '#default_value' => $entity->get('pageH'),
    ];
    $form['pageW'] = [
      '#type' => 'number',
      '#title' => $this->t('largeur de page (mm)'),
      '#default_value' => $entity->get('pageW'),
    ];

    $form['marginT'] = [
      '#type' => 'number',
      '#title' => $this->t('Top margin'),
      '#default_value' => $entity->get('marginT'),
    ];
    $form['marginB'] = [
      '#type' => 'number',
      '#title' => $this->t('Bottom margin'),
      '#default_value' => $entity->get('marginB'),
    ];
    $form['marginW'] = [
      '#type' => 'number',
      '#title' => $this->t('printer margin width (mm)'),
      '#default_value' => $entity->get('marginW')
    ];

    $form['versoOffsetY'] = [
      '#type' => 'number',
      '#title' => $this->t('printer offset Y for verso (mm)'),
      '#default_value' => $entity->get('versoOffsetY')
    ];
    $form['versoOffsetX'] = [
      '#type' => 'number',
      '#title' => $this->t('printer offset X for verso (mm)'),
      '#default_value' => $entity->get('versoOffsetX')
    ];

    $form['cardH'] = [
      '#type' => 'number',
      '#title' => $this->t('hauteur de carte (mm)'),
      '#default_value' => $entity->get('cardH'),
    ];
    $form['cardW'] = [
      '#type' => 'number',
      '#title' => $this->t('largeur de carte (mm)'),
      '#default_value' => $entity->get('cardW'),
    ];
    $form['cardLandscape'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Imprimer les cartes en mode paysage'),
      '#default_value' => $entity->get('cardLandscape')
    ];

    // Ajoute d'autres champs ici...

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\print_settings\Entity\PrintSettings $entity */
    $entity = $this->entity;
    $entity->set('label', $form_state->getValue('label'));
    $entity->set('id', $form_state->getValue('id'));
    $entity->set('pageH', $form_state->getValue('pageH'));
    $entity->set('pageW', $form_state->getValue('pageW'));
    $entity->set('marginT', $form_state->getValue('marginT'));
    $entity->set('marginB', $form_state->getValue('marginB'));
    $entity->set('marginW', $form_state->getValue('marginW'));
    $entity->set('versoOffsetY', $form_state->getValue('versoOffsetY'));
    $entity->set('versoOffsetX', $form_state->getValue('versoOffsetX'));
    $entity->set('cardH', $form_state->getValue('cardH'));
    $entity->set('cardW', $form_state->getValue('cardW'));
    $entity->set('cardLandscape', $form_state->getValue('cardLandscape'));

    $entity->save();

    $this->messenger()->addMessage($this->t('Saved %label.', ['%label' => $entity->label()]));
    $form_state->setRedirectUrl( new Url('entity.print_settings.collection'));
  }
}