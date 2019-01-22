<?php
/**
 * Displays the user interface for the Autoclass Manager meta box.
 *
 * This is a partial template that is included by the Autoclass Manager
 * Admin class that is used to display all of the information that is related
 * to the car meta data for the given car.
 */
?>
<div id="mb-cars-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $link = !empty($values['mb_link']) ? esc_attr($values['mb_link'][0]) : '';
        $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : 'off';

        wp_nonce_field('sliders_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <!-- Target -->
    <p class="content-mb">
        <label for="mb_target">¿Mostrar en otra pestaña?</label>
        <input type="checkbox" name="mb_target" id="mb_target" <?php checked($target, 'on'); ?> />
    </p>
    
    <!-- Link -->
    <p class="content-mb">
        <label for="mb_link">Enlace: </label>
        <input type="text" name="mb_link" id="mb_link" value="<?php echo $link; ?>" />
    </p>
</div>