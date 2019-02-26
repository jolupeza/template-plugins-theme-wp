<?php

namespace AltimeaQuiz\Admin;

use AltimeaQuiz\Admin\Custommetaboxes\QuizMetaBoxes;
use AltimeaQuiz\Admin\Customposts\Quiz;
use AltimeaQuiz\Includes\AltimeaQuizLoader;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/admin
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaQuizAdmin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $altimea_quiz    The ID of this plugin.
	 */
	private $altimea_quiz;

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
     * @var      AltimeaQuizLoader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    protected $domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $altimea_quiz       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
     * @param      string    $domain     Domain by multilanguages
     * @param      AltimeaQuizLoader $loader The loader that's responsible for maintaining and registering all hooks.
	 */
	public function __construct($altimea_quiz, $version, $domain, AltimeaQuizLoader $loader)
    {
		$this->altimea_quiz = $altimea_quiz;
		$this->version = $version;
		$this->loader = $loader;
		$this->domain = $domain;
	}

	public function loadCustomPostQuiz()
    {
	    $quiz = new Quiz($this->domain);
	    $mbQuiz = new QuizMetaBoxes($quiz);

	    $this->loader->add_action('init', $quiz, 'registerPostType');
	    $this->loader->add_action('init', $quiz, 'registerTaxonomy');
	    $this->loader->add_action('add_meta_boxes', $mbQuiz, 'cd_mb_quiz_add');
	    $this->loader->add_action('save_post', $mbQuiz, 'cd_mb_quiz_save');
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
		 * defined in AltimeaQuizLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AltimeaQuizLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->altimea_quiz, plugin_dir_url( __FILE__ ) . 'css/altimea-quiz-admin.css', array(), $this->version, 'all' );
	}
}
