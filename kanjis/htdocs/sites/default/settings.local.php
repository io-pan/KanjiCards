<?php

$settings['trusted_host_patterns'] = [ '.*' ];

$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;

$config['system.logging']['error_level'] = 'verbose';
$config['environment_indicator.indicator']['bg_color'] = "#60e5f3";
$config['environment_indicator.indicator']['fg_color'] = "#ffffff";
$config['environment_indicator.indicator']['name'] = 'local';

$settings['config_sync_directory'] = '../config-drupal';
$settings['file_temp_path'] = 'C:\Users\ROUSSEAUL\Documents\www_Deps\_Temp'; // 'tmp';
$settings['file_public_path'] = 'sites/default/files';
//$settings['file_public_path'] = '../../_Public';
$settings['file_private_path'] = 'C:\Users\ROUSSEAUL\Documents\www_Deps\_Private\kanjis';

$config['locale.settings']['translation']['path'] = 'sites/default/files/translations';
$config['locale.settings']['translation']['use_source'] = 'local';
$settings['custom_translations_directory'] = $config['locale.settings']['translation']['path'];

/**
 * Database settings
 */
$databases['default']['default'] = array(
    'database' => 'kanjis',
    'username' => 'root',
    'password' => '',
    'host' => 'localhost',
    'prefix' => '',
    'port' => '3306',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'driver' => 'mysql',
);
