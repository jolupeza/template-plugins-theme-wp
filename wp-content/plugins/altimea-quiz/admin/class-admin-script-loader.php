<?php

namespace AltimeaQuiz\Admin;

use AltimeaQuiz\Includes\AltimeaQuizLoader;
use AltimeaQuiz\Util\AssetsInterface;

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
 * @link       http://www.altimea.com
 * @implements AssetsInterface
 * @since      1.1.0
 *
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/public
 */
class AdminScriptLoader implements AssetsInterface
{
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
     * @var      string    $altimeaQuiz    The ID of this plugin.
     */
    private $altimeaQuiz;

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      AltimeaQuizLoader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string             $altimeaQuiz   The name of the plugin.
     * @param string             $version       The version of this plugin.
     * @param AltimeaQuizLoader  $loader        The loader that's responsible for maintaining and registering all hooks
     */
    public function __construct($altimeaQuiz, $version, AltimeaQuizLoader $loader)
    {
        $this->version = $version;
        $this->altimeaQuiz = $altimeaQuiz;
        $this->loader = $loader;
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
         * defined in AltimeaQuizLoader as all of the hooks are defined
         * in that particular class.
         *
         * The AltimeaQuizLoader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->altimeaQuiz, plugin_dir_url( __FILE__ ) . 'js/altimea-quiz-admin.js', array( 'jquery' ), $this->version, false );
    }

    /**
     * Registers the 'enqueue' function with the proper WordPress hook for
     * registering stylesheets.
     */
    public function init()
    {
        $this->loader->add_action('admin_enqueue_scripts', $this, 'enqueue');
    }
}
