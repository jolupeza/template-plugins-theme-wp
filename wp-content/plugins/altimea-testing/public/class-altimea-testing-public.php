<?php

namespace AltimeaTesting\Front;

use AltimeaTesting\Includes\Libraries\AltimeaTestingGulpfile;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/public
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaTestingPublic
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $altimea_testing    The ID of this plugin.
     */
    private $altimea_testing;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $altimea_testing       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($altimea_testing, $version)
    {

        $this->altimea_testing = $altimea_testing;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        $fileName = 'altimea-testing-main.css';
        $newFileName = AltimeaTestingGulpfile::getFileNameMD5( $fileName );

        if (file_exists(plugin_dir_path( ALTIMEA_TESTING_FILE ) . 'public/assets/css/' . $newFileName)) {
            wp_enqueue_style($this->altimea_testing, plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'public/assets/css/' . $newFileName, array(), $this->version, 'all');
        } else {
            wp_enqueue_style($this->altimea_testing, plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'public/assets/css/' . $fileName, array(), $this->version, 'all');
        }

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        $fileName = 'altimea-testing-main.js';
        $newFileName = AltimeaTestingGulpfile::getFileNameMD5( $fileName );

        if (file_exists(plugin_dir_path( ALTIMEA_TESTING_FILE ) . 'public/assets/js/' . $newFileName)) {
            wp_enqueue_script($this->altimea_testing, plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'public/assets/js/' . $newFileName, array( 'jquery' ), $this->version, false);
        } else {
            wp_enqueue_script($this->altimea_testing, plugin_dir_url( ALTIMEA_TESTING_FILE ) . 'public/assets/js/' . $fileName, array( 'jquery' ), $this->version, false);
        }

    }

    public function filterContent($content)
    {
        if (is_single() && in_the_loop() && is_main_query()) {
            return $content . "<div class=\"alert alert-success\">Probando ando</div>";
        }

        return $content;
    }
}
