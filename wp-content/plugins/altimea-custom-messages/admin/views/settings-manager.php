<div class="wrap">
 
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    
    <?php do_action('altimea_settings_messages'); ?>
 
    <form method="post" action="<?php echo esc_html(admin_url('admin-post.php')); ?>">
        <h2 class="title">Formulario de Cotización</h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="facebook_id">Facebook ID</label>
                </th>
                <td>
                    <input name="facebook_id" type="text" id="facebook_id" value="<?php _e(esc_attr($facebookId)); ?>" class="regular-text" />
                </td>
            </tr>
<!--            <tr>
                <th scope="row">
                    <label for="subject-email">Asunto</label>
                </th>
                <td>
                    <input name="subject-email" type="text" id="subject-email" value="<?php //echo esc_attr($subjectEmail); ?>" class="large-text code" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="email-response">Mensaje de respuesta al cliente</label>
                </th>
                <td>
                    <textarea class="large-text code" name="email-response" id="email-response" rows="5" cols="50"><?php //echo esc_attr($emailResponse); ?></textarea>
                </td>
            </tr>-->
        </table>
            
        <?php        
            wp_nonce_field( 'altimea-custom-messages-settings-save', 'altimea-custom-message' );
            
            submit_button();
        ?>
    </form>
 
</div><!-- .wrap -->