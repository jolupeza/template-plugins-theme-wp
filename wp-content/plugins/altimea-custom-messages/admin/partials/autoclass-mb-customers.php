<?php
/**
 * Displays the user interface for the Autoclass Manager meta box by type content Customers.
 *
 * This is a partial template that is included by the Autoclass Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-customers-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $name = !empty($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
        $apePat = !empty($values['mb_apePat']) ? esc_attr($values['mb_apePat'][0]) : '';
        $apeMat = !empty($values['mb_apeMat']) ? esc_attr($values['mb_apeMat'][0]) : '';
        $email = !empty($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
        $phone = !empty($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        $typeDoc = !empty($values['mb_typeDoc']) ? esc_attr($values['mb_typeDoc'][0]) : '';
        $numDoc = !empty($values['mb_numDoc']) ? esc_attr($values['mb_numDoc'][0]) : '';
        $car = !empty($values['mb_car']) ? (int)esc_attr($values['mb_car'][0]) : 0;

        wp_nonce_field('customers_meta_box_nonce', 'meta_box_nonce');
        
        $the_car = null;
        
        if ($car) {        
            $args = [
                'post_type' => 'cars',
                'p' => $car,
                'posts_per_page' => 1
            ];

            $the_car = new WP_Query($args);
        }
    ?>

    <!-- Name-->
    <p class="content-mb">
        <label for="mb_name">Nombre: </label>
        <input type="text" name="mb_name" id="mb_name" value="<?php _e($name); ?>" />
    </p>
    
    <!-- apePat-->
    <p class="content-mb">
        <label for="mb_apePat">Apellido Paterno: </label>
        <input type="text" name="mb_apePat" id="mb_apePat" value="<?php _e($apePat); ?>" />
    </p>
    
    <!-- apeMat-->
    <p class="content-mb">
        <label for="mb_apeMat">Apellido Materno: </label>
        <input type="text" name="mb_apeMat" id="mb_apeMat" value="<?php _e($apeMat); ?>" />
    </p>

    <!-- Email-->
    <p class="content-mb">
        <label for="mb_email">Correo electrónico: </label>
        <input type="email" name="mb_email" id="mb_email" value="<?php _e($email); ?>" />
    </p>

    <!-- Phone-->
    <p class="content-mb">
        <label for="mb_phone">Teléfono: </label>
        <input type="text" name="mb_phone" id="mb_phone" value="<?php _e($phone); ?>" />
    </p>
    
    <!-- Type Doc-->
    <p class="content-mb">
        <label for="mb_typeDoc">Tipo de Documento: </label>
        <select name="mb_typeDoc" id="mb_typeDoc">
            <option value="">-- Seleccione --</option>
            <option value="dni" <?php selected($typeDoc, 'dni'); ?>>D.N.I.</option>
            <option value="ce" <?php selected($typeDoc, 'ce'); ?>>C.E.</option>
        </select>
    </p>

    <!-- Number Document-->
    <p class="content-mb">
        <label for="mb_numDoc">Nro. Documento: </label>
        <input type="text" name="mb_numDoc" id="mb_numDoc" value="<?php _e($numDoc); ?>" />
    </p>
    
    <?php if ($the_car && $the_car->have_posts()) : ?>
        <?php while ($the_car->have_posts()) : ?>
            <?php $the_car->the_post(); ?>
            <!-- Auto -->
            <p class="content-mb">
                <label for="mb_car">Auto: </label>
                <input type="text" name="mb_car" id="mb_car" value="<?php the_title(); ?>" />
            </p>
        <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div><!-- #single-post-meta-manager -->