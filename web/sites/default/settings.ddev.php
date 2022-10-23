<?php

$host = getenv('DRUPAL_DB_HOST');
$port = getenv('DRUPAL_DB_PORT');
$driver = "mysql";

// If DDEV_PHP_VERSION is not set but IS_DDEV_PROJECT *is*, it means we're running (drush) on the host,
// so use the host-side bind port on docker IP
if (empty(getenv('DDEV_PHP_VERSION') && getenv('IS_DDEV_PROJECT') == 'true')) {
  $host = "127.0.0.1";
  $port = 49158;
}

$databases['default']['default'] = array(
  'database' => getenv('DRUPAL_DB_NAME'),
  'username' => getenv('DRUPAL_DB_USER'),
  'password' => getenv('DRUPAL_DB_PASS'),
  'host' => $host,
  'driver' => $driver,
  'port' => $port,
  'prefix' => "",
);

$settings['hash_salt'] = getenv('HASH_SALT');

// This will ensure the site can only be accessed through the intended host
// names. Additional host patterns can be added for custom configurations.
$settings['trusted_host_patterns'] = ['.*'];

// Don't use Symfony's APCLoader. ddev includes APCu; Composer's APCu loader has
// better performance.
$settings['class_loader_auto_detect'] = FALSE;

// Set $settings['config_sync_directory'] if not set in settings.php.
if (empty($settings['config_sync_directory'])) {
  $settings['config_sync_directory'] = 'sites/default/files/sync';
}

// Enable local development services.
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/ddev.development.services.yml';

// Override drupal/symfony_mailer default config to use Mailhog
$config['symfony_mailer.mailer_transport.sendmail']['plugin'] = 'smtp';
$config['symfony_mailer.mailer_transport.sendmail']['configuration']['user']='';
$config['symfony_mailer.mailer_transport.sendmail']['configuration']['pass']='';
$config['symfony_mailer.mailer_transport.sendmail']['configuration']['host']='localhost';
$config['symfony_mailer.mailer_transport.sendmail']['configuration']['port']='1025';

// Override drupal/swiftmailer default config to use Mailhog
$config['swiftmailer.transport']['transport'] = 'smtp';
$config['swiftmailer.transport']['smtp_host'] = '127.0.0.1';
$config['swiftmailer.transport']['smtp_port'] = '1025';
$config['swiftmailer.transport']['smtp_encryption'] = '0';
