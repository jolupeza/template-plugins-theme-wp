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
        $activityLog = new ActivityLog($this->altimeaTesting, $this->version);
        $downloadLog = new AltimeaTestingDownload($activityLog);
        $uploadLog = new AltimeTestingLogImport($activityLog);

        $this->loader->add_action('admin_menu', $submenu, 'addOptionsPage');
        $this->loader->add_action('admin_init', $downloadLog, 'downloadLog');
        $this->loader->add_action('admin_init', $uploadLog, 'uploadLog');
        $this->loader->add_action('admin_notice', $uploadLog, 'importNotice');
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

        wp_enqueue_style( $this->altimeaTesting, plugin_dir_url( __FILE__ ) . 'css/altimea-testing-admin.css', array(), $this->version, 'all' );
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

        wp_enqueue_script( $this->altimeaTesting, plugin_dir_url( __FILE__ ) . 'js/altimea-testing-admin.js', array( 'jquery' ), $this->version, false );
    }

    public function screenHelp($contextualHelp, $screenId, $screen)
    {
        // The add_help_tab function for screen was introduced in WP 3.3
        if (!method_exists($screen, 'add_help_tab')) {
            return $contextualHelp;
        }

        /* --- generate help content ---*/
        $helpContent = $this->getHelpContent($screenId, $screen);

        $screen->add_help_tab([
            'id' => 'altimea-screen-help',
            'title' => 'Screen Information',
            'content' => $helpContent,
        ]);

        return $contextualHelp;
    }

    private function getHelpContent($screenId, $screen)
    {
        global $hook_suffix;

        // List screen properties
        $variables = '<ul style="width:50%;float:left;"><strong>Screen variables </strong>'
            . sprintf( '<li> Screen id : %s</li>', $screenId )
            . sprintf( '<li> Screen base : %s</li>', $screen->base )
            . sprintf( '<li>Parent base : %s</li>', $screen->parent_base )
            . sprintf( '<li> Parent file : %s</li>', $screen->parent_file )
            . sprintf( '<li> Hook suffix : %s</li>', $hook_suffix )
            . '</ul>';

        // Append global $hook_suffix to the hook stems
        $hooks = array(
            "load-$hook_suffix",
            "admin_print_styles-$hook_suffix",
            "admin_print_scripts-$hook_suffix",
            "admin_head-$hook_suffix",
            "admin_footer-$hook_suffix"
        );

        // If add_meta_boxes or add_meta_boxes_{screen_id} is used, list these too
        if ( did_action( 'add_meta_boxes_' . $screenId ) )
            $hooks[] = 'add_meta_boxes_' . $screenId;

        if ( did_action( 'add_meta_boxes' ) )
            $hooks[] = 'add_meta_boxes';

        // Get List HTML for the hooks
        $hooks = '<ul style="width:50%;float:left;"><strong>Hooks</strong> <li>' . implode( '</li><li>', $hooks ) . '</li></ul>';

        // Combine $variables list with $hooks list.
        return $variables . $hooks;
    }
}
