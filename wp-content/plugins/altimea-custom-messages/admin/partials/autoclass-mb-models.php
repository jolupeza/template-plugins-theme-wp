<?php
/**
 * Displays the user interface for the Autoclass Manager meta box.
 *
 * This is a partial template that is included by the Autoclass Manager
 * Admin class that is used to display all of the information that is related
 * to the model meta data for the given model.
 */
?>
<div id="mb-models-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $brand = isset($values['mb_brand']) ? esc_attr($values['mb_brand'][0]) : '';

        wp_nonce_field('models_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <?php
        $args = [
            'post_type' => 'brands',
            'posts_per_brand' => -1,
        ];
        
        $brands = new WP_Query($args);
    ?>
    <!-- Brand -->
    <p class="content-mb">
        <label for="mb_brand">Marcas: </label>
        <select name="mb_brand" id="mb_brand">
            <option value="">-- Seleccione marca --</option>
            <?php if ($brands->have_posts()) : ?>
                <?php while ($brands->have_posts()) : ?>
                    <?php $brands->the_post(); ?>
                    <option value="<?php echo get_the_ID(); ?>" <?php selected($brand, get_the_ID()) ?>>
                        <?php the_title(); ?>
                    </option>
                <?php endwhile; ?>
            <?php endif; ?>11
            <?php wp_reset_postdata(); ?>
        </select>
    </p>
</div>