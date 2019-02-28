<?php

namespace AltimeaQuiz\Front;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaQuiz
 * @subpackage AltimeaQuiz/public
 */

use AltimeaQuiz\Includes\AltimeaQuizLoader;

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
class AltimeaQuizPublic
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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $altimea_quiz       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
     * @param      AltimeaQuizLoader $loader The loader that's responsible for maintaining and registering all hooks.
	 */
	public function __construct($altimea_quiz, $version, AltimeaQuizLoader $loader)
    {
		$this->altimea_quiz = $altimea_quiz;
		$this->version = $version;
		$this->loader = $loader;
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
	public function enqueue_scripts()
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

		$fileName = 'altimea-quiz-main.js';
		$newFileName = AltimeaQuizGulpfile::getFileNameMD5( $fileName );

		if ( file_exists( plugin_dir_path( ALTIMEA_QUIZ_FILE ) . 'public/assets/js/' . $newFileName ) ) {
			wp_enqueue_script( $this->altimea_quiz, plugin_dir_url( ALTIMEA_QUIZ_FILE ) . 'public/assets/js/' . $newFileName, array( 'jquery' ), $this->version, false );
		} else {
			wp_enqueue_script( $this->altimea_quiz, plugin_dir_url( ALTIMEA_QUIZ_FILE ) . 'public/assets/js/' . $fileName, array( 'jquery' ), $this->version, false );
		}
	}

	public function loadShortcode()
    {
        add_shortcode('wpq_show_quiz', array($this, 'wpqShowQuiz'));
    }

    public function wpqShowQuiz($atts)
    {
        global $post;

        $html = '<div id="quiz_panel"><form action="" method="POST">';
        $html .= '<div class="toolbar">';
        $html .= '<div class="toolbar_item"><select name="quiz_category" id="quiz_category">';

        // Retrive the quiz categories from database
        $quiz_categories = get_terms( 'quiz_categories', 'hide_empty=1' );

        foreach ($quiz_categories as $quiz_category) {
            $html .= '<option value="' . $quiz_category->term_id . '">' . $quiz_category->name . '</option>';
        }

        $html .= '</select></div>';
        $html .= '<input type="hidden" value="select_quiz_cat" name="wpq_action" />';
        $html .= '<div class="toolbar_item"><input type="submit" value="Select Quiz Category" /></div>';
        $html .= '</form>';
        $html .= '<div class="complete toolbar_item" ><input type="button" id="completeQuiz" value="Get Results" /></div>';

        // Implementation of Form Submission
        $questions_str = "";

        if (isset($_POST['wpq_action']) && 'select_quiz_cat' == $_POST['wpq_action']) {
            $html .= '<div id="timer" style="display: block;"></div>';
            $html .= '<div style="clear: both;"></div></div>';

            $quiz_category_id = $_POST['quiz_category'];
            $quiz_num = get_option('wpq_num_questions');
            $args = array(
                'post_type' => 'altimea_quiz',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'quiz_categories',
                        'field' => 'id',
                        'terms' => $quiz_category_id
                    )
                ),
                'orderby' => 'rand',
                'post_status' => 'publish',
                'posts_per_page' => $quiz_num
            );

            $query = new WP_Query($args);

            $quiz_index = 1;
            while ($query->have_posts()) : $query->the_post();
                // Generating the HTML for Questions
                $question_id = get_the_ID();
                $question = the_title( '', '', FALSE ) . ' ' . get_the_content();
                $question_answers = json_decode( get_post_meta( $question_id, '_question_answers', true ) );
                $questions_str .= '<li>';
                $questions_str .= '<div class="ques_title"><span class="quiz_num">' . $quiz_index . '</span>' . $question . '</div>';
                $questions_str .= '<div class="ques_answers" data-quiz-id="' . $question_id . '">';

                $question_index = 1;
                foreach ($question_answers as $key => $value) {
                    if ( '' != $value ) {
                        $questions_str .= $question_index . ' <input type="radio" value="' . $question_index . '" name="ans_' . $question_id . '[]" />' . $value . '<br/>';
                    }

                    $question_index++;
                }

                $questions_str .= '</div></li>';

                $quiz_index++;
            endwhile;
            wp_reset_query();
            // Embedding Slider
            $html .= '<ul id="slider">' . $questions_str;
            $html .= '<li id="quiz_result_page"><div class="ques_title">Quiz Results <span id="score"></span></div>';
            $html .= '<div id="quiz_result"></div>';
            $html .= '</li></ul></div>';
        } else {
            $html .= '<div id="timer" style="display: none;"></div>';
            $html .= '<div style="clear: both;"></div></div>';
        }

        // Displaying the Quiz as unorderd list

        return $html;
    }
}
