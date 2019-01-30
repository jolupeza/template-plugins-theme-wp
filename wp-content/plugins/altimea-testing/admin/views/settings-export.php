<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <form method="post" action="" id="altimea-export-log-form">
        <h2 class="title"><?php __('Export Activity Logs', 'altimeatesting'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="action"><?php _e('Click to export the activity logs', 'altimeatesting'); ?></label>
                </th>
                <td>
                    <input name="action" type="hidden" id="action" value="<?php _e('export-logs'); ?>" class="regular-text" />
                </td>
            </tr>
        </table>

        <?php
        wp_nonce_field( 'altimea-testing-export-logs-save', '_wplnonce' );

        submit_button(__('Download Activity Logs', 'altimeatesting'), 'button');
        ?>
    </form>

    <form method="post" action="" enctype="multipart/form-data">
        <p>
            <label for="altimea_import_logs"><?php _e( 'Import an .xml file.', 'altimeatesting' ); ?></label>
            <input type="file" id="altimea_import_logs" name="altimea_import" />
        </p>
        <input type="hidden" name="action" value="import-logs" />
        <?php wp_nonce_field( 'altimea-testing-import-logs', '_wplnonce' ); ?>
        <?php submit_button( __( 'Upload Activity Logs', 'altimeatesting' ), 'primary' ); ?>
    </form>

</div><!-- .wrap -->
