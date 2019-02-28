<div class="wrap">
    <form method="post" name="options" action="options.php">
        <h2><?php _e(esc_html(get_admin_page_title())); ?></h2>

        <?php wp_nonce_field('update-options'); ?>

        <table class="form-table">
            <tr>
                <th align="left" scope="row">
                    <label for="wpq_num_questions">Number of Questions</label>
                </th>
                <td>
                    <input type="text" class="small-text" id="wpq_num_questions" name="wpq_num_questions" value="<?php _e(get_option( 'wpq_num_questions' )); ?>" />
                </td>
            </tr>
            <tr>
                <th align="left" scope="row">
                    <label for="wpq_duration">Duration (Mins)</label>
                </th>
                <td>
                    <input type="text" class="small-text" id="wpq_duration" name="wpq_duration" value="<?php _e(get_option( 'wpq_duration' )); ?>" />
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="wpq_num_questions,wpq_duration" />
            <input class="button button-primary" type="submit" name="Submit" value="Update" />
        </p>

    </form>
</div>
