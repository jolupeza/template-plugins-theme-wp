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
 * @since             1.0.0
 * @package           AltimeaQuiz
 *
 * @wordpress-plugin
 * Plugin Name:       Altimea Quiz
 * Plugin URI:        http://www.altimea.com
 * Description:       Create dynamic multiple choice quiz for Wordpress
 * Version:           1.0.0
 * Author:            Altimea
 * Author URI:        http://www.altimea.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       altimea-quiz
 * Domain Path:       /languages
 */

namespace AltimeaQuiz;

use AltimeaQuiz\Includes\AltimeaQuiz;
use AltimeaQuiz\Includes\AltimeaQuizActivator;
use AltimeaQuiz\Includes\AltimeaQuizDeactivator;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'ALTIMEA_QUIZ_FILE' ) ) {
	define( 'ALTIMEA_QUIZ_FILE', __FILE__ );
}

require_once( trailingslashit(dirname(__FILE__)) . 'inc/autoloader.php' );

require __DIR__ . '/vendor/autoload.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-altimea-quiz-activator.php
 * @param Boolean $networkwide status multisite
 * @return Void
 */
function activate_altimea_quiz() {
	AltimeaQuizActivator::getInstance()->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-altimea-quiz-deactivator.php
 * @param Boolean $networkwide status multisite
 * @return Void
 */
function deactivate_altimea_quiz() {
	AltimeaQuizDeactivator::getInstance()->deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\activate_altimea_quiz' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate_altimea_quiz' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_altimea_quiz() {
	$plugin = new AltimeaQuiz();
	$plugin->run();
}
run_altimea_quiz();
