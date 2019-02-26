<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/public
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaQuizPublic {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $altimea_quiz       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $altimea_quiz, $version ) {

		$this->altimea_quiz = $altimea_quiz;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		$fileName = 'altimea-quiz-main.css';
		$newFileName = AltimeaQuizGulpfile::getFileNameMD5( $fileName );

		if ( file_exists( plugin_dir_path( ALTIMEA_QUIZ_FILE ) . 'public/assets/css/' . $newFileName ) ) {
			wp_enqueue_style( $this->altimea_quiz, plugin_dir_url( ALTIMEA_QUIZ_FILE ) . 'public/assets/css/' . $newFileName, array(), $this->version, 'all' );
		} else {
			wp_enqueue_style( $this->altimea_quiz, plugin_dir_url( ALTIMEA_QUIZ_FILE ) . 'public/assets/css/' . $fileName, array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		$fileName = 'altimea-quiz-main.js';
		$newFileName = AltimeaQuizGulpfile::getFileNameMD5( $fileName );

		if ( file_exists( plugin_dir_path( ALTIMEA_QUIZ_FILE ) . 'public/assets/js/' . $newFileName ) ) {
			wp_enqueue_script( $this->altimea_quiz, plugin_dir_url( ALTIMEA_QUIZ_FILE ) . 'public/assets/js/' . $newFileName, array( 'jquery' ), $this->version, false );
		} else {
			wp_enqueue_script( $this->altimea_quiz, plugin_dir_url( ALTIMEA_QUIZ_FILE ) . 'public/assets/js/' . $fileName, array( 'jquery' ), $this->version, false );
		}

	}

}
