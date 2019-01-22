<?php

namespace Altimea_Custom_Messages\Includes;

use Altimea_Custom_Messages\Includes\Altimea_Custom_Messages_Loader;

use Altimea_Custom_Messages\Shared\Altimea_Custom_Messages_Deserializer as Deserializer;

/*use Autoclass_Manager\Admin\Autoclass_Manager_Admin;
use Autoclass_Manager\Admin\CSS_Loader;
use Autoclass_Manager\Admin\Script_Loader;
use Autoclass_Manager\Admin\Autoclass_Manager_Models;
use Autoclass_Manager\Admin\Autoclass_Manager_Cars;
use Autoclass_Manager\Admin\Autoclass_Manager_Customers;
use Autoclass_Manager\Admin\Autoclass_Manager_Sliders;*/

use Altimea_Custom_Messages\Admin\Altimea_Custom_Messages_Submenu;
use Altimea_Custom_Messages\Admin\Altimea_Custom_Messages_Submenu_Page;
use Altimea_Custom_Messages\Admin\Altimea_Custom_Messages_Serializer as Serializer;
use Altimea_Custom_Messages\Admin\Settings_Messenger;

/*
use Autoclass_Manager\Front\Autoclass_Manager_Public;
use Autoclass_Manager\Front\Script_Loader as Script_Loader_Public;
use Autoclass_Manager\Front\CSS_Loader as CSS_Loader_Public;*/

/**
 * The Altimea Custom Messages is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin.
 */

/**
 * The Altimea Custom Messages is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin.
 *
 * The Altimea Custom Messages includes an instance to the Altimea Custom Messages
 * Loader which is responsible for coordinating the hooks that exist within the
 * plugin.
 *
 * It also maintains a reference to the plugin slug which can be used in
 * internationalization, and a reference to the current version of the plugin
 * so that we can easily update the version in a single place to provide
 * cache busting functionality when including scripts and styles.
 *
 * @since    1.0.0
 */
class Altimea_Custom_Messages
{
    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var \Altimea_Custom_Messages\Includes\Altimea_Custom_Messages_Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    protected $loader;
    
    /**
     * A references to the deserializer
     * 
     * @var \Altimea_Custom_Messages\Shared\Altimea_Custom_Messages_Deserializer
     */
    protected $deserializer;

    /**
     * Represents the slug of hte plugin that can be used throughout the plugin
     * for internationalization and other purposes.
     *
     * @var string The single, hyphenated string used to identify this plugin.
     */
    protected $plugin_slug;

    /**
     * Maintains the current version of the plugin so that we can use it throughout
     * the plugin.
     *
     * @var string The current version of the plugin.
     */
    protected $version;

    /**
     * Instantiates the plugin by setting up the core properties and loading
     * all necessary dependencies and defining the hooks.
     *
     * The constructor will define both the plugin slug and the verison
     * attributes, but will also use internal functions to import all the
     * plugin dependencies, and will leverage the Single_Post_Meta_Loader for
     * registering the hooks and the callback functions used throughout the
     * plugin.
     */
    public function __construct()
    {
        $this->plugin_slug = 'altimea-custom-messages-slug';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Imports the Autoclass administration classes, and the Autoclass Loader.
     *
     * The Altimea Custom Messages administration class defines all unique functionality for
     * introducing custom functionality into the WordPress dashboard.
     *
     * The Altimea Custom Messages Loader is the class that will coordinate the hooks and callbacks
     * from WordPress and the plugin. This function instantiates and sets the reference to the
     * $loader class property.
     */
    private function load_dependencies()
    {
        $this->loader = new Altimea_Custom_Messages_Loader();
        $this->deserializer = new Deserializer();
    }

    /**
     * Defines the hooks and callback functions that are used for setting up the plugin stylesheets
     * and the plugin's meta box.
     *
     * This function relies on the Maletek Manager Admin class and the Maletek Manager
     * Loader class property.
     */
    private function define_admin_hooks()
    {
        /*$admin = new Altimea_Custom_Messages_Admin($this->get_version());
        $this->loader->add_action('init', $admin, 'add_post_type');
        $this->loader->add_action('rest_api_init', $admin, 'rest_filter_add_filters');

        $cssLoader = new CSS_Loader($this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $cssLoader, 'enqueue');

        $jsLoader = new Script_Loader($this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $jsLoader, 'enqueue');

        $adminModels = new Altimea_Custom_Messages_Models();
        $this->loader->add_action('add_meta_boxes', $adminModels, 'cd_mb_models_add');
        $this->loader->add_action('save_post', $adminModels, 'cd_mb_models_save');
        $this->loader->add_filter('manage_edit-models_columns', $adminModels, 'custom_columns_models');
        $this->loader->add_action('manage_models_posts_custom_column', $adminModels, 'custom_column_models');

        $adminCars = new Altimea_Custom_Messages_Cars();

        $this->loader->add_action('init', $adminCars, 'add_taxonomies_cars');
        $this->loader->add_action('add_meta_boxes', $adminCars, 'cd_mb_cars_add');
        $this->loader->add_action('save_post', $adminCars, 'cd_mb_cars_save');
        $this->loader->add_filter('manage_edit-cars_columns', $adminCars, 'custom_columns_cars');
        $this->loader->add_action('manage_cars_posts_custom_column', $adminCars, 'custom_column_cars');

        $adminCustomers = new Altimea_Custom_Messages_Customers();
        $this->loader->add_action('add_meta_boxes', $adminCustomers, 'cd_mb_customers_add');
        $this->loader->add_filter('manage_edit-customers_columns', $adminCustomers, 'custom_columns_customers');
        $this->loader->add_action('manage_customers_posts_custom_column', $adminCustomers, 'custom_column_customers');
        $this->loader->add_filter('views_edit-customers', $adminCustomers, 'customers_button_view_edit');

        $adminSliders = new Altimea_Custom_Messages_Sliders();
        $this->loader->add_action('add_meta_boxes', $adminSliders, 'cd_mb_sliders_add');
        $this->loader->add_action('save_post', $adminSliders, 'cd_mb_sliders_save');*/
        
        $messenger = new Settings_Messenger();
        $this->loader->add_action('altimea_settings_messages', $messenger, 'getAllMessages');

        $submenu = new Altimea_Custom_Messages_Submenu(
                        $this->version,
                        new Altimea_Custom_Messages_Submenu_Page($this->deserializer)
                    );
        $serializer = new Serializer($messenger);

        $this->loader->add_action('admin_menu', $submenu, 'add_options_page');
        $this->loader->add_action('admin_post', $serializer, 'save');
    }

    /**
     * Defines the hooks and callback functions that are used for rendering information on the front
     * end of the site.
     *
     * This function relies on the Altimea Custom Messages Public class and the Altimea Custom Messages
     * Loader class property.
     */
    private function define_public_hooks()
    {
        /*$public = new Altimea_Custom_Messages_Public($this->version, $this->deserializer);

        $cssLoader = new CSS_Loader_Public($this->get_version(), $deserializer);
        $jsLoader = new Script_Loader_Public($this->version);

        $this->loader->add_action('wp_enqueue_scripts', $jsLoader, 'enqueue', 50);
        $this->loader->add_action('wp_enqueue_scripts', $cssLoader, 'enqueue');*/
    }

    /**
     * Sets this class into motion.
     *
     * Executes the plugin by calling the run method of the loader class which will
     * register all of the hooks and callback functions used throughout the plugin
     * with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * Returns the current version of the plugin to the caller.
     *
     * @return string $this->version    The current version of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
