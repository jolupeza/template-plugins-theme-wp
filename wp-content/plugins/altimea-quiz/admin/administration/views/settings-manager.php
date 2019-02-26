<div class="wrap">
    <form method="post" name="options" action="options.php">
        <h2><?php _e(esc_html(get_admin_page_title())); ?></h2>

        <?php wp_nonce_field( 'quiz-settings-save', 'quiz-custom-message' ); ?>

        <table width="100%" cellpadding="10" class="form-table">
            <tr>
                <td align="left" scope="row">
                    <label>Number of Questions</label><input type="text" name="wpq_num_questions" value="<?php _e(get_option( 'wpq_num_questions' )); ?>" />
                </td>
            </tr>
            <tr>
                <td align="left" scope="row">
                    <label>Duration (Mins)</label><input type="text" name="wpq_duration" value="<?php _e(get_option( 'wpq_duration' )); ?>" />
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="wpq_num_questions,wpq_duration" />
            <?php submit_button('Update'); ?>
        </p>

    </form>
</div>
