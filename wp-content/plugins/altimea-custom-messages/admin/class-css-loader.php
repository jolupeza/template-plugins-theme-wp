<?php

namespace Autoclass_Manager\Admin;

use Autoclass_Manager\Util\Assets_Interface;

/**
 * Provides a consistent way to enqueue all administrative-related stylesheets.
 */

/**
 * Provides a consistent way to enqueue all administrative-related stylesheets.
 *
 * Implements the Assets_Interface by defining the init function and the
 * enqueue function.
 *
 * The first is responsible for hooking up the enqueue
 * callback to the proper WordPress hook. The second is responsible for
 * actually registering and enqueuing the file.
 *
 * @implements Assets_Interface
 * @since      1.1.0
 */
class CSS_Loader implements Assets_Interface
{
    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version)
    {
        $this->version = $version;
    }

    /**
     * Defines the functionality responsible for loading the file.
     */
    public function enqueue()
    {
        wp_enqueue_style(
            'autoclass-manager-admin',
            plugin_dir_url(__FILE__) . '/css/autoclass-manager-admin.css',
            array(),
            $this->version,
            false
        );
    }

    /**
     * Registers the 'enqueue' function with the proper WordPress hook for
     * registering stylesheets.
     */
    public function init()
    {
        add_action(
            'wp_enqueue_scripts',
            array( $this, 'enqueue' )
        );
    }

}
