<?php
/**
 * The file responsible for starting the Altimea Custom Messages plugin.
 *
 * The Altimea Custom Messages is a plugin it allows display custom messages.
 *
 * @package           Altimea_Custom_Messages
 *
 * @wordpress-plugin
 * Plugin Name:       Altimea Custom Messages
 * Plugin URI:        https://bitbucket.org/jolupeza/autoclass-wp
 * Description:       Display custom messages.
 * Version:           1.0.0
 * Author:            Altimea
 * Author URI:        https://altimea.com
 * Text Domain:       altimea-custom-messages-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

namespace Altimea_Custom_Messages;

use Altimea_Custom_Messages\Includes\Altimea_Custom_Messages;

// If this file is called directly, then abort execution.
if (!defined('WPINC')) {
    die;
}

require_once( trailingslashit(dirname(__FILE__)) . 'inc/autoload.php' );

/**
 * Instantiates the Autoclass Manager class and then
 * calls its run method officially starting up the plugin.
 */
function run_altimea_custom_messages()
{
    $spmm = new Altimea_Custom_Messages();
    $spmm->run();
}

// Call the above function to begin execution of the plugin.
run_altimea_custom_messages();
