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
class ScriptLoader implements AssetsInterface
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
     * Register the JavaScript for the public-facing side of the site.
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
         * 'http://localhost:8080/app.js'
         */
        if (is_page_template('templates/vue-search-app-template.php')) {
            $filesJs = $this->spaFile->getFilesSpa('js');
            if (!empty($filesJs)) {
                $this->registerChunk($filesJs);

                $this->registerApp($filesJs);
            }
        }

        $fileName = 'altimea-testing-main.js';
        $newFileName = AltimeaTestingGulpfile::getFileNameMD5( $fileName );

        if (file_exists(plugin_dir_path( ALTIMEA_TESTING_FILE ) . 'public/assets/js/' . $newFileName)) {
            wp_enqueue_script($this->altimeaTesting, plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'public/assets/js/' . $newFileName, array( 'jquery' ), $this->version, true);
        } else {
            wp_enqueue_script($this->altimeaTesting, plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'public/assets/js/' . $fileName, array( 'jquery' ), $this->version, true);
        }
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

    private function registerChunk($files)
    {
        foreach ($files as $file) {
            if (strpos($file, 'chunk-') === 0) {
                wp_enqueue_script(
                    'vue_search_chunk',
                    plugin_dir_url(ALTIMEA_TESTING_FILE) . 'spa/dist/js/' . $file,
                    array(), $this->version, true);
            }
        }
    }

    private function registerApp($files)
    {
        foreach ($files as $file) {
            if (strpos($file, 'app.') === 0) {
                wp_register_script(
                    'vue_search_app',
                    plugin_dir_url(ALTIMEA_TESTING_FILE) . 'spa/dist/js/' . $file,
                    array(), $this->version, true);

                wp_localize_script(
                    'vue_search_app',
                    'wpData',
                    $this->getWpData()
                );

                wp_enqueue_script('vue_search_app');
            }
        }
    }

    private function getWpData()
    {
        global $post;

        return array(
            'plugin_directory_uri' => plugin_dir_url(ALTIMEA_TESTING_FILE),
            'rest_url' => untrailingslashit(esc_url_raw(rest_url())),
            'app_path' => $post->post_name,
            'post_categories' => get_terms(array(
                'taxonomy' => 'category',
                'hide_empty' => true,
                'fields' => 'names',
            ))
        );
    }
}
