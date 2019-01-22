<?php

/**
 * Loads all of the classes in the diretory, instantiates the Autoloader,
 * and registers it with the standard PHP library.
 *
 * @package Altimea_Custom_Messages\Inc
 */

foreach ( glob( dirname( __FILE__ ) . '/class-*.php' ) as $filename ) {
    include_once( $filename );
}

$autoloader = new Autoloader();
spl_autoload_register(array($autoloader, 'load'));
