<?php

namespace Drupal\print_settings\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\print_settings\PrintSettingsInterface;

use Drupal\Core\Entity\ContentEntityBase;
/**
 * Defines the Print Settings entity.
 *
 * @ConfigEntityType(
 *   id = "print_settings",
 *   label = @Translation("Print Setting"),
 *   handlers = {
 *     "list_builder" = "Drupal\print_settings\PrintListBuilder",
 *     "form" = {
 *       "add" = "Drupal\print_settings\Form\PrintSettingsForm",
 *       "edit" = "Drupal\print_settings\Form\PrintSettingsForm",
 *       "delete" = "Drupal\print_settings\Form\PrintSettingsDeleteForm",
 *     }
 *   },
 *   config_prefix = "print_settings",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "pageH",
 *     "pageW",
 *     "marginT",
 *     "marginB",
 *     "marginW",
 *     "versoOffsetY",
 *     "versoOffsetX",
 *     "cardH",
 *     "cardW",
 *     "cardLandscape"
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/media/print_settings/{print_settings}",
 *     "delete-form" = "/admin/config/media/print_settings/{print_settings}/delete",
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
