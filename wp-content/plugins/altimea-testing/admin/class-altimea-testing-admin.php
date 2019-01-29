<?php

namespace AltimeaTesting\Admin;

use AltimeaTesting\Admin\Modules\ActivityLog;
use AltimeaTesting\Includes\AltimeaTestingLoader;
use AltimeaTesting\Shared\AltimeaTestingDeserializer;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/admin
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaTestingAdmin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $altimeaTesting    The ID of this plugin.
     */
    private $altimeaTesting;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      AltimeaTestingLoader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * A references to the deserializer
     *
     * @var \AltimeaTesting\Shared\AltimeaTestingDeserializer
     */
    protected $deserializer;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string               $altimeaTesting     The name of this plugin.
     * @param      string               $version            The version of this plugin.
     * @param      AltimeaTestingLoader $loader             Responsible for maintaining and registering all hooks
     */
    public function __construct($altimeaTesting, $version, AltimeaTestingLoader $loader)
    {
        $this->altimeaTesting = $altimeaTesting;
        $this->version = $version;
        $this->loader = $loader;
        $this->deserializer = new AltimeaTestingDeserializer();
    }

    public function loadHooksActivityLog()
    {
        $activityLog = new ActivityLog($this->altimeaTesting, $this->version);

        $this->loader->add_action('init', $activityLog, 'registerActivityLogTable', 1);
        $this->loader->add_action('switch_blog', $activityLog, 'registerActivityLogTable');
        $this->loader->add_action('admin_init', $activityLog, 'activityLogUpgradeCheck');
    }

    public function loadHooksActivityLogAdminPage()
    {
        $submenu = new AltimeaTestingSubmenu($this->version, (new AltimeaTestingSubmenuPage($this->deserializer)));
        $downloadLog = new AltimeaTestingDownload((new ActivityLog($this->altimeaTesting, $this->version)));
        $uploadLog = new AltimeTestingLogImport();

        $this->loader->add_action('admin_menu', $submenu, 'addOptionsPage');
        $this->loader->add_action('admin_init', $downloadLog, 'downloadLog');
        $this->loader->add_action('admin_init', $uploadLog, 'uploadLog');
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in AltimeaTestingLoader as all of the hooks are defined
         * in that particular class.
         *
         * The AltimeaTestingLoader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->altimea_testing, plugin_dir_url( __FILE__ ) . 'css/altimea-testing-admin.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in AltimeaTestingLoader as all of the hooks are defined
         * in that particular class.
         *
         * The AltimeaTestingLoader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->altimea_testing, plugin_dir_url( __FILE__ ) . 'js/altimea-testing-admin.js', array( 'jquery' ), $this->version, false );
    }
}
