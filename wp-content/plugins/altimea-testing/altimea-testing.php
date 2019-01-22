<?php

/**
 * WordPress plugin generator by Altimea
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.altimea.com
 * @since             2.0.0
 * @package           AltimeaTesting
 *
 * @wordpress-plugin
 * Plugin Name:       Altimea Testing
 * Plugin URI:        http://www.altimea.com
 * Description:       Plugin by testing generator plugins altimea
 * Version:           1.0.0
 * Author:            Altimea
 * Author URI:        http://www.altimea.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       altimea-testing
 * Domain Path:       /languages
 */

namespace AltimeaTesting;

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
use AltimeaTesting\Includes\AltimeaTesting;
use AltimeaTesting\Includes\AltimeaTestingActivator;
use AltimeaTesting\Includes\AltimeaTestingDeactivator;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! defined( 'ALTIMEA_TESTING_FILE' ) ) {
    define( 'ALTIMEA_TESTING_FILE', __FILE__ );
}

require_once( trailingslashit(dirname(__FILE__)) . 'inc/autoloader.php' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-altimea-testing-activator.php
 * @param Boolean $networkwide status multisite
 * @return Void
 */
function activate_altimea_testing($networkwide) {
    AltimeaTestingActivator::activate($networkwide);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-altimea-testing-deactivator.php
 * @param Boolean $networkwide status multisite
 * @return Void
 */
function deactivate_altimea_testing($networkwide) {
    AltimeaTestingDeactivator::deactivate($networkwide);
}

register_activation_hook( __FILE__, 'activate_altimea_testing' );
register_deactivation_hook( __FILE__, 'deactivate_altimea_testing' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_altimea_testing() {
    $plugin = new AltimeaTesting();
    $plugin->run();
}

run_altimea_testing();
