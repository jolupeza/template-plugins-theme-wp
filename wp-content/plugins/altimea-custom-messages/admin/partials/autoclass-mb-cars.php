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

        $brand = !empty($values['mb_brand']) ? esc_attr($values['mb_brand'][0]) : '';
        $model = !empty($values['mb_model']) ? esc_attr($values['mb_model'][0]) : '';
        $feeMonth = !empty($values['mb_feeMonth']) ? esc_attr($values['mb_feeMonth'][0]) : '';
        $showChars = isset($values['mb_showChars']) ? esc_attr($values['mb_showChars'][0]) : 'off';
        $licensePlate = isset($values['mb_licensePlate']) ? esc_attr($values['mb_licensePlate'][0]) : '';
        $mileage = !empty($values['mb_mileage']) ? esc_attr($values['mb_mileage'][0]) : '';
        $fuel = isset($values['mb_fuel']) ? esc_attr($values['mb_fuel'][0]) : '';
        $color = !empty($values['mb_color']) ? esc_attr($values['mb_color'][0]) : '';
        $year = !empty($values['mb_year']) ? esc_attr($values['mb_year'][0]) : '';
        $formRodante = !empty($values['mb_formRodante']) ? esc_attr($values['mb_formRodante'][0]) : '';
        $motor = !empty($values['mb_motor']) ? esc_attr($values['mb_motor'][0]) : '';
        $serie = !empty($values['mb_serie']) ? esc_attr($values['mb_serie'][0]) : '';
        $version = !empty($values['mb_version']) ? esc_attr($values['mb_version'][0]) : '';
        $axes = !empty($values['mb_axes']) ? esc_attr($values['mb_axes'][0]) : '';
        $seating = !empty($values['mb_seating']) ? esc_attr($values['mb_seating'][0]) : '';
        $passengers = !empty($values['mb_passengers']) ? esc_attr($values['mb_passengers'][0]) : '';
        $wheels = !empty($values['mb_wheels']) ? esc_attr($values['mb_wheels'][0]) : '';
        $bodywork = !empty($values['mb_bodywork']) ? esc_attr($values['mb_bodywork'][0]) : '';
        $power = !empty($values['mb_power']) ? esc_attr($values['mb_power'][0]) : '';
        $cylinder = !empty($values['mb_cylinder']) ? esc_attr($values['mb_cylinder'][0]) : '';
        $accesories = !empty($values['mb_accesories']) ? $values['mb_accesories'][0] : '';
        $contact = !empty($values['mb_contact']) ? $values['mb_contact'][0] : '';
        $images = !empty($values['mb_images']) ? $values['mb_images'][0] : '';
        $isSold = isset($values['mb_isSold']) ? esc_attr($values['mb_isSold'][0]) : 'off';

        wp_nonce_field('cars_meta_box_nonce', 'meta_box_nonce');
        $totalImages = 4;
        $count = 0;
    ?>
    
    <?php
        $argsBrand = [
            'post_type' => 'brands',
            'posts_per_page' => -1
        ];
        
        $brands = new WP_Query($argsBrand);
    ?>
    
    <!-- Brand -->
    <p class="content-mb">
        <label for="mb_brand">Marca: </label>
        <select name="mb_brand" id="mb_brand">
            <option value="">-- Seleccione marca --</option>
            <?php if ($brands->have_posts()) : ?>
                <?php while ($brands->have_posts()) : ?>
                    <?php $brands->the_post(); ?>
                    <option value="<?php echo get_the_ID(); ?>" <?php selected($brand, get_the_ID()) ?>>
                        <?php the_title(); ?>
                    </option>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </select>
    </p>
    
    <?php
        $argsModel = [
            'post_type' => 'models',
            'posts_per_page' => -1,
        ];

        $models = new WP_Query($argsModel);
    ?>
    <!-- Model -->
    <p class="content-mb">
        <label for="mb_model">Modelo: </label>
        <select name="mb_model" id="mb_model">
            <option value="">-- Seleccione modelo --</option>
            
            <?php  // if (!empty($model)) : ?>
                <?php if ($models->have_posts()) : ?>
                    <?php while ($models->have_posts()) : ?>
                        <?php $models->the_post(); ?>
                        <option value="<?php echo get_the_ID(); ?>" <?php selected($model, get_the_ID()) ?>>
                            <?php the_title(); ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            <?php // endif; ?>
        </select>
    </p>
    
    <!-- showChars -->
    <p class="content-mb">
        <label for="mb_showChars">¿Mostrar características?</label>
        <input type="checkbox" name="mb_showChars" id="mb_showChars" <?php checked($showChars, 'on'); ?> />
    </p>
    
    <!-- showChars -->
    <p class="content-mb">
        <label for="mb_isSold">¿Vendido?</label>
        <input type="checkbox" name="mb_isSold" id="mb_isSold" <?php checked($isSold, 'on'); ?> />
    </p>
    
    <!-- FeeMonth-->
    <p class="content-mb">
        <label for="mb_feeMonth">Cuota mensual desde: </label>
        <input type="text" name="mb_feeMonth" id="mb_feeMonth" value="<?php echo $feeMonth; ?>" />
    </p>
    
    <!-- Color -->
    <p class="content-mb">
        <label for="mb_color">Color: </label>
        <input type="text" name="mb_color" id="mb_color" value="<?php echo $color; ?>" />
    </p>
    
    <!-- Lincese Plate -->
    <p class="content-mb">
        <label for="mb_licensePlate">Placa: </label>
        <input type="text" name="mb_licensePlate" id="mb_licensePlate" value="<?php echo $licensePlate; ?>" />
    </p>
    
    <!-- Mileage -->
    <p class="content-mb">
        <label for="mb_mileage">Kilometraje: </label>
        <input type="text" name="mb_mileage" id="mb_mileage" value="<?php echo $mileage; ?>" />
    </p>
    
    <!-- Year -->
    <p class="content-mb">
        <label for="mb_year">Año de Fabricación: </label>
        <input type="text" name="mb_year" id="mb_year" value="<?php echo $year; ?>" />
    </p>
    
    <!-- Fuel -->
    <p class="content-mb">
        <label for="mb_fuel">Combustible: </label>
        <input type="text" name="mb_fuel" id="mb_fuel" value="<?php echo $fuel; ?>" />
    </p>
    
    <!-- Form Rodante -->
    <p class="content-mb">
        <label for="mb_formRodante">Form Rodante: </label>
        <input type="text" name="mb_formRodante" id="mb_formRodante" value="<?php echo $formRodante; ?>" />
    </p>
    
    <!-- Motor -->
    <p class="content-mb">
        <label for="mb_motor">Motor: </label>
        <input type="text" name="mb_motor" id="mb_motor" value="<?php echo $motor; ?>" />
    </p>
    
    <!-- Serie chasis -->
    <p class="content-mb">
        <label for="mb_serie">Serie Chasis: </label>
        <input type="text" name="mb_serie" id="mb_serie" value="<?php echo $serie; ?>" />
    </p>
    
    <!-- Version -->
    <p class="content-mb">
        <label for="mb_version">Versión: </label>
        <input type="text" name="mb_version" id="mb_version" value="<?php echo $version; ?>" />
    </p>
    
    <!-- Axes -->
    <p class="content-mb">
        <label for="mb_axes">Ejes: </label>
        <input type="text" name="mb_axes" id="mb_axes" value="<?php echo $axes; ?>" />
    </p>
    
    <!-- Seating -->
    <p class="content-mb">
        <label for="mb_seating">Asientos: </label>
        <input type="text" name="mb_seating" id="mb_seating" value="<?php echo $seating; ?>" />
    </p>
    
    <!-- Passengers -->
    <p class="content-mb">
        <label for="mb_passengers">Pasajeros: </label>
        <input type="text" name="mb_passengers" id="mb_passengers" value="<?php echo $passengers; ?>" />
    </p>
    
    <!-- Wheels -->
    <p class="content-mb">
        <label for="mb_wheels">Ruedas: </label>
        <input type="text" name="mb_wheels" id="mb_wheels" value="<?php echo $wheels; ?>" />
    </p>
    
    <!-- BodyWork -->
    <p class="content-mb">
        <label for="mb_bodywork">Carrocería: </label>
        <input type="text" name="mb_bodywork" id="mb_bodywork" value="<?php echo $bodywork; ?>" />
    </p>
    
    <!-- Power -->
    <p class="content-mb">
        <label for="mb_power">Potencia: </label>
        <input type="text" name="mb_power" id="mb_power" value="<?php echo $power; ?>" />
    </p>
    
    <!-- Cylinder -->
    <p class="content-mb">
        <label for="mb_cylinder">Cilindros: </label>
        <input type="text" name="mb_cylinder" id="mb_cylinder" value="<?php echo $cylinder; ?>" />
    </p>
    
    <!-- Contact -->
    <h2 class="Subtitle hndle"><span>Información de Contacto:</span></h2>
    <?php
        $settings = array(
            'wpautop' => false,
            'textarea_name' => 'mb_contact',
            'media_buttons' => true,
            'textarea_rows' => 10,
        );
        wp_editor($contact, 'mb_contact', $settings);
    ?>
    
    <!-- Accesories-->
    <h2 class="Subtitle hndle"><span>Accesorios:</span></h2>
    <?php
        $settings = array(
            'wpautop' => false,
            'textarea_name' => 'mb_accesories',
            'media_buttons' => true,
            'textarea_rows' => 10,
        );
        wp_editor($accesories, 'mb_accesories', $settings);
    ?>
    
    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Imágenes</legend>

        <?php if (!empty($images)) : ?>
            <?php
                $images = unserialize($images);

                $count = count($images);
            ?>
            <?php foreach ($images as $img) : ?>
                <div class="container-upload-file GroupForm-wrapperImage">
                    <p class="btn-add-file">
                        <a title="Set Slider Image" href="javascript:;" class="set-file button button-primary">Añadir</a>
                    </p>

                    <div class="hidden media-container">
                        <img src="<?php echo $img; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true );  ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true );  ?>" />
                    </div><!-- .media-container -->

                    <p class="hidden">
                        <a title="Qutar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar</a>
                    </p>

                    <p class="media-info">
                        <input class="hd-src" type="hidden" name="mb_images[]" value="<?php echo $img; ?>" />
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($count < $totalImages) : ?>
            <?php for ($i = 0; $i < ($totalImages - $count); $i++) : ?>
                <div class="container-upload-file GroupForm-wrapperImage">
                    <p class="btn-add-file">
                        <a title="Set Slider Image" href="javascript:;" class="set-file button button-primary">Añadir</a>
                    </p>

                    <div class="hidden media-container">
                        <img src="" />
                    </div><!-- .media-container -->

                    <p class="hidden">
                        <a title="Remove Footer Image" href="javascript:;" class="remove-file button button-secondary">Quitar</a>
                    </p>

                    <p class="media-info">
                        <input class="hd-src" type="hidden" name="mb_images[]" value="" />
                    </p>
                </div>
            <?php endfor; ?>
        <?php endif; ?>
    </fieldset><!-- end GroupFrm -->
</div>