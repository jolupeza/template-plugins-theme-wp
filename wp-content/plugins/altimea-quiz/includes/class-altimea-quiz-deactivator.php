<?php

namespace AltimeaQuiz\Includes;

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/includes
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaQuizDeactivator
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
	 * Short Description. (use period)
	 *
	 * Long Description.
     * $networkwide
	 *
	 * @since    1.0.0
	 * @return Void
	 */
	public function deactivate()
    {
		// apply logic to delete configuration data or anything
		if (getenv('WP_ENV') === 'dev') {

		}
	}

}
