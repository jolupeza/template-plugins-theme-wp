<?php

namespace Testing;

/**
 * Loads all of the classes in the diretory, instantiates the Autoloader,
 * and registers it with the standard PHP library.
 *
 * @package Altimea_Custom_Messages\Inc
 */

require plugin_dir_path(__FILE__) . '../vendor/autoload.php';

$autoloader = new Autoloader();
spl_autoload_register(array($autoloader, 'load'));
