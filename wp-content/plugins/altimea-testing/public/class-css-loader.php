<?php

namespace AltimeaTesting\Front;

use AltimeaTesting\Shared\Spafile;
use AltimeaTesting\Util\AssetsInterface;
use AltimeaTesting\Shared\AltimeaTestingDeserializer;
use AltimeaTesting\Includes\Libraries\AltimeaTestingGulpfile;

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
 * @link       http://www.altimea.com
 * @implements AssetsInterface
 * @since      1.1.0
 *
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/public
 */
class CssLoader implements AssetsInterface
{
    /**
     *
     * @var \AltimeaTesting\Shared\AltimeaTestingDeserializer;
     */
    private $deserializer;

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $altimea_testing    The ID of this plugin.
     */
    private $altimeaTesting;

    private $spaFile;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string                     $altimeaTesting   The name of the plugin.
     * @param string                     $version           The version of this plugin.
     * @param AltimeaTestingDeserializer $deserializer      Retrieves information from the database.
     */
    public function __construct($altimeaTesting, $version, AltimeaTestingDeserializer $deserializer)
    {
        $this->version = $version;
        $this->deserializer = $deserializer;
        $this->altimeaTesting = $altimeaTesting;
        $this->spaFile = Spafile::getInstance();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue()
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

        $fileName = 'altimea-testing-main.css';
        $newFileName = AltimeaTestingGulpfile::getFileNameMD5( $fileName );

        if (file_exists(plugin_dir_path( ALTIMEA_TESTING_FILE ) . 'public/assets/css/' . $newFileName)) {
            wp_enqueue_style(
                $this->altimeaTesting,
                plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'public/assets/css/' . $newFileName,
                array(),
                $this->version,
                'all'
            );
        } else {
            wp_enqueue_style(
                $this->altimeaTesting,
                plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'public/assets/css/' . $fileName,
                array(),
                $this->version,
                'all'
            );
        }

        $filesCss = $this->spaFile->getFilesSpa('css');

        wp_enqueue_style(
            'vue_search_app',
            plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'spa/dist/css/' . $filesCss[0],
            array(),
            $this->version,
            'all'
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
