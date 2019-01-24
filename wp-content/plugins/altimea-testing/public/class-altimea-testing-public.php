<?php

namespace AltimeaTesting\Front;

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
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $altimeaTesting       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($altimeaTesting, $version)
    {
        $this->altimeaTesting = $altimeaTesting;
        $this->version = $version;
    }

    public function filterContent($content)
    {
        if (is_single() && in_the_loop() && is_main_query()) {
            return $content . "<div class=\"alert alert-success\">Probando ando</div>";
        }

        return $content;
    }
}
