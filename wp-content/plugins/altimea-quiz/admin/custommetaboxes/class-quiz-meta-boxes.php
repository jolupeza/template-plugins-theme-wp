<?php

namespace AltimeaQuiz\Admin\Custommetaboxes;

use AltimeaQuiz\Admin\Customposts\Quiz;

class QuizMetaBoxes
{
    private $quiz;

    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function cd_mb_quiz_add()
    {
        add_meta_box(
            'mb-quiz-id',
            'Quiz Answers Info',
            array($this, 'render_mb_quiz'),
            $this->quiz->getPostType(),
            'normal',
            'high'
        );
    }

    public function render_mb_quiz()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/altimea-mb-quiz.php';
    }

    public function cd_mb_quiz_save($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if (empty($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'quiz_meta_box_nonce')) {
            return $post_id;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if ($this->quiz->getPostType() !== $_POST['post_type']) {
            return $post_id;
        }

        $questionAnswers = !empty($_POST['quiz_answer']) ? $_POST['quiz_answer'] : array();
        $filteredAnswers = array();

        foreach ( $questionAnswers as $answer ) {
            array_push($filteredAnswers, sanitize_text_field(trim($answer)));
        }

        $questionAnswers = json_encode( $filteredAnswers );

        $data = [
            'mb_questions_answers' => $questionAnswers,
            'mb_question_correct_answer' => !empty($_POST['correct_answer']) ? sanitize_text_field(trim($_POST['correct_answer'])) : ""
        ];

        $this->updateCustomMeta($post_id, $data);
    }

    private function updateCustomMeta($postId, $data = array())
    {
        foreach ($data as $meta => $value) {
            if (!empty($value)) {
                update_post_meta($postId, $meta, $value);
            } else {
                delete_post_meta($postId, $meta);
            }
        }
    }

}
