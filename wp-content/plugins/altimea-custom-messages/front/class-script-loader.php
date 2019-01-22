<?php

namespace Autoclass_Manager\Front;

use Autoclass_Manager\Util\Assets_Interface;

/**
 * Provides a consistent way to enqueue all administrative-related scripts.
 */

/**
 * Provides a consistent way to enqueue all administrative-related scripts.
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
class Script_Loader implements Assets_Interface
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
        wp_enqueue_script(
            'autoclass-manager-formValidation',
            plugin_dir_url(__FILE__) . 'js/formValidation/formValidation.js',
            array('jquery'),
            $this->version,
            true
        );
        
        wp_enqueue_script(
            'autoclass-manager-formValidation-bootstrap',
            plugin_dir_url(__FILE__) . 'js/formValidation/framework/bootstrap.js',
            array('jquery'),
            $this->version,
            true
        );
        
        wp_enqueue_script(
            'autoclass-manager-formValidation-language',
            plugin_dir_url(__FILE__) . 'js/formValidation/language/es_ES.js',
            array('jquery'),
            $this->version,
            true
        );
        
        wp_enqueue_script(
            'autoclass-manager-public',
            plugin_dir_url(__FILE__) . 'js/script.js',
            array('jquery'),
            $this->version,
            true
        );

        wp_localize_script(
            'autoclass-manager-public',
            'AutoclassManagerAjax',
            array(
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('autoclassajax-nonce')
            )
        );
    }

    /**
     * Registers the 'enqueue' function with the proper WordPress hook for
     * registering scripts.
     */
    public function init()
    {
        add_action(
            'wp_enqueue_scripts',
            array( $this, 'enqueue' )
        );
    }

}
