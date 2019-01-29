<?php

namespace AltimeaTesting\Includes;

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/includes
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaTestingDeactivator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     * @return Void
     */
    public static function deactivate()
    {
        global $wpdb;

        //Remove our table (if it exists)
        $wpdb->query("DROP TABLE IF EXISTS $wpdb->activity_log");

        //Remove the database version
        delete_option('altimea_activity_log_version');

        // apply logic to delete configuration data or anything
        if (getenv('WP_ENV') === 'dev') {

        }
    }
}
