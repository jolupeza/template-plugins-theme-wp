<?php
/**
 * Displays the user interface for the Altimea Quiz meta box by type content altimea_quiz.
 *
 * This is a partial template that is included by the Altimea Quiz
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-quiz-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $questionAnswers = empty($values['mb_questions_answers']) ? array('', '', '', '', '') : json_decode($values['mb_questions_answers'][0]);
        $questionCorrectAnswer = !empty($values['mb_question_correct_answer']) ? sanitize_text_field(trim($values['mb_question_correct_answer'][0])) : null;

        wp_nonce_field('quiz_meta_box_nonce', 'meta_box_nonce');
    ?>

    <table class="form-table">
        <tr>
            <th><label for="correct_answer">Correct Answer</label></th>
            <td>
                <select name="correct_answer" id="correct_answer" class="widefat">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <?php if ($questionCorrectAnswer == $i) : ?>
                            <option value="<?php _e($i); ?>" selected>Answer <?php _e($i); ?></option>
                        <?php else : ?>
                            <option value="<?php _e($i); ?>">Answer <?php _e($i); ?></option>
                        <?php endif; ?>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <?php $index = 1; ?>
        <?php foreach ($questionAnswers as $questionAnswer) : ?>
            <tr><th><label for="quiz_answer<?php _e($index); ?>">Answer <?php _e($index); ?></label></th><td><textarea name="quiz_answer[]" id="quiz_answer<?php _e($index); ?>" class="widefat"><?php _e(esc_textarea(trim($questionAnswer))); ?></textarea></td></tr>
        <?php $index++; ?>
        <?php endforeach; ?>
    </table>
</div>
