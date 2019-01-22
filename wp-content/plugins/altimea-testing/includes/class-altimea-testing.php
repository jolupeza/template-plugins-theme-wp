<?php

namespace AltimeaTesting\Includes;

use AltimeaTesting\Includes\AltimeaTestingLoader;
use AltimeaTesting\Includes\AltimeaTestingI18n;
use AltimeaTesting\Admin\AltimeaTestingAdmin;
use AltimeaTesting\Front\AltimeaTestingPublic;
use AltimeaTesting\Shared\AltimeaTestingDeserializer as Deserializer;
use AltimeaTesting\Front\CssLoader;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/includes
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaTesting
{
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
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $altimea_testing    The string used to uniquely identify this plugin.
     */
    protected $altimea_testing;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * A references to the deserializer
     *
     * @since   2.0.0
     * @access  protected
     * @var     Deserializer  A references to the deserializer
     */
    protected $deserializer;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->altimea_testing = 'altimea-testing';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - AltimeaTestingLoader. Orchestrates the hooks of the plugin.
     * - AltimeaTestingI18n. Defines internationalization functionality.
     * - AltimeaTestingAdmin. Defines all hooks for the admin area.
     * - AltimeaTestingPublic. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        $this->loader = new AltimeaTestingLoader();
        $this->deserializer = new Deserializer();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the AltimeaTestingi18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new AltimeaTestingi18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new AltimeaTestingAdmin( $this->get_altimea_testing(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new AltimeaTestingPublic( $this->get_altimea_testing(), $this->get_version() );
        $cssLoader = new CssLoader($this->get_version(), $this->deserializer, $this->get_altimea_testing());

        $this->loader->add_action('wp_enqueue_scripts', $cssLoader, 'enqueue');

        //$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        
        $this->loader->add_filter('the_content', $plugin_public, 'filterContent');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_altimea_testing()
    {
        return $this->altimea_testing;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    AltimeaTestingLoader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
