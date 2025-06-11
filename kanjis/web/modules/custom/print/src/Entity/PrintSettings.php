<?php

namespace Drupal\PrintSettings\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\PrintSettings\PrintSettingsInterface;

/**
 * Defines the Example entity.
 *
 * @ConfigEntityType(
 *   id = "PrintSettings",
 *   label = @Translation("Example"),
 *   handlers = {
 *     "list_builder" = "Drupal\PrintSettings\ExampleListBuilder",
 *     "form" = {
 *       "add" = "Drupal\PrintSettings\Form\ExampleForm",
 *       "edit" = "Drupal\PrintSettings\Form\ExampleForm",
 *       "delete" = "Drupal\PrintSettings\Form\ExampleDeleteForm",
 *     }
 *   },
 *   config_prefix = "PrintSettings",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label"
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/system/PrintSettings/{PrintSettings}",
 *     "delete-form" = "/admin/config/system/PrintSettings/{PrintSettings}/delete",
 *   }
 * )
 */
class PrintSettings extends ConfigEntityBase implements PrintSettingsInterface {

  /**
   * The PrintSettings ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The PrintSettings label.
   *
   * @var string
   */
  protected $label;

  // Your specific configuration property get/set methods go here,
  // implementing the interface.
}
