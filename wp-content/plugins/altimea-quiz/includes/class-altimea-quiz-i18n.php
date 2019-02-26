<?php

namespace AltimeaQuiz\Includes;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/includes
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaQuizI18n
{
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
    {
		load_plugin_textdomain(
			'altimea-quiz',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}



}
