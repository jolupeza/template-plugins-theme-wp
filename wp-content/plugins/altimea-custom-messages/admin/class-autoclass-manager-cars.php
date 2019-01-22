<?php

namespace Autoclass_Manager\Admin;

class Autoclass_Manager_Cars
{
    private $domain;
    private $allowed;
    
    public function __construct()
    {
        $this->domain  = 'autoclass-framework';
        
        $this->allowed = array(
            'p' => array(
                'style' => array(),
            ),
//            'a' => array(// on allow a tags
//                'href' => array(),
//                'target' => array(),
//            ),
            'ul' => array(
                'class' => array(),
            ),
//            'ol' => array(),
            'li' => array(
                'style' => array(),
            ),
//            'strong' => array(),
//            'br' => array(),
//            'span' => [
//                'class' => [],
//            ],
//            'h1' => [],
//            'h2' => [],
            'h3' => [],
            'h4' => [],
            'h5' => []
//            'img' => [
//                'alt' => [],
//                'class' => [],
//                'src' => [],
//            ],
        );
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type cars.
     */
    public function cd_mb_cars_add()
    {
        add_meta_box(
            'mb-cars-id', 'Datos del Auto', array($this, 'render_mb_cars'), 'cars', 'normal', 'core'
        );
    }
    
    public function cd_mb_cars_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (empty(filter_input(INPUT_POST, 'meta_box_nonce')) || !wp_verify_nonce(filter_input(INPUT_POST, 'meta_box_nonce'), 'cars_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        $data = [
            'mb_brand' => filter_input(INPUT_POST, 'mb_brand'),
            'mb_model' => filter_input(INPUT_POST, 'mb_model'),
            'mb_feeMonth' => !empty(filter_input(INPUT_POST, 'mb_feeMonth')) ? floatval(filter_input(INPUT_POST, 'mb_feeMonth')) : 0,
            'mb_showChars' => !empty(filter_input(INPUT_POST, 'mb_showChars')) ? 'on' : 'off',
            'mb_isSold' => !empty(filter_input(INPUT_POST, 'mb_isSold')) ? 'on' : 'off',
            'mb_licensePlate' => filter_input(INPUT_POST, 'mb_licensePlate'),
            'mb_fuel' => filter_input(INPUT_POST, 'mb_fuel'),
            'mb_formRodante' => filter_input(INPUT_POST, 'mb_formRodante'),
            'mb_color' => filter_input(INPUT_POST, 'mb_color'),
            'mb_mileage' => filter_input(INPUT_POST, 'mb_mileage'),
            'mb_year' => filter_input(INPUT_POST, 'mb_year'),
            'mb_motor' => filter_input(INPUT_POST, 'mb_motor'),
            'mb_serie' => filter_input(INPUT_POST, 'mb_serie'),
            'mb_version' => filter_input(INPUT_POST, 'mb_version'),
            'mb_axes' => filter_input(INPUT_POST, 'mb_axes'),
            'mb_passengers' => filter_input(INPUT_POST, 'mb_passengers'),
            'mb_wheels' => filter_input(INPUT_POST, 'mb_wheels'),
            'mb_bodywork' => filter_input(INPUT_POST, 'mb_bodywork'),
            'mb_power' => filter_input(INPUT_POST, 'mb_power'),
            'mb_seating' => filter_input(INPUT_POST, 'mb_seating'),
            'mb_cylinder' => filter_input(INPUT_POST, 'mb_cylinder'),
            'mb_accesories' => [filter_input(INPUT_POST, 'mb_accesories'), true],
            'mb_contact' => [filter_input(INPUT_POST, 'mb_contact'), true],
        ];
        
        $this->updateCustomMeta($post_id, $data);
        
        $this->updateSerializeMeta($post_id, $_POST['mb_images'], 'mb_images');
    }
    
    private function updateCustomMeta($postId, $data = array())
    {        
        foreach ($data as $meta => $value) {
            if (!empty($value)) {
                if (is_array($value) && $value[1]) {
                    update_post_meta($postId, $meta, wp_kses($value[0], $this->allowed));
                } else {
                    update_post_meta($postId, $meta, esc_attr($value));
                }
            } else {
                delete_post_meta($postId, $meta);
            }
        }
    }
    
    private function updateSerializeMeta($postId, $data, $meta) 
    {
        $newArr = [];
        
        foreach ($data as $item) {
            if (!empty($item)) {
                $newArr[] = $item;
            }
        }
        
        if (count($newArr)) {
            update_post_meta($postId, $meta, $newArr);
        } else {
            delete_post_meta($postId, $meta);
        }
    }
    
    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_cars()
    {
        require_once plugin_dir_path(__FILE__).'partials/autoclass-mb-cars.php';
    }
    
    /**
     * Add custom taxonomies cars_state to post type cars.
     */
    public function add_taxonomies_cars()
    {
        $labels = array(
            'name' => _x('Estados', 'Taxonomy plural name', $this->domain),
            'singular_name' => _x('Estado', 'Taxonomy singular name', $this->domain),
            'search_items' => __('Buscar Estado', $this->domain),
            'popular_items' => __('Estados Populares', $this->domain),
            'all_items' => __('Todos los Estados', $this->domain),
            'parent_item' => __('Estado Padre', $this->domain),
            'parent_item_colon' => __('Estado Padre', $this->domain),
            'edit_item' => __('Editar Estado', $this->domain),
            'update_item' => __('Actualizar Estado', $this->domain),
            'add_new_item' => __('Añadir nuevo Estado', $this->domain),
            'new_item_name' => __('Nuevo Estado', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Estado', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Estados', $this->domain),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => [
                'slug' => 'estado',
                'with_front' => false,
            ],
            'show_in_rest' => true,
            'rest_base' => 'states',
//            'capabilities' => array(),
        );

        register_taxonomy('cars_state', 'cars', $args);
    }

    public function custom_columns_cars($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Auto'),
            'brand' => __('Marca'),
            'model' => __('Modelo'),
            'author' => __('Autor'),
            'taxonomy-cars_state' => __('Estados'),
            'date' => __('Fecha'),
        );

        return $columns;
    }

    public function custom_column_cars($column)
    {
        global $post;

        // Setup some vars
        $values = get_post_custom($post->ID);
        $brand = !empty($values['mb_brand']) ? get_the_title(esc_attr($values['mb_brand'][0])) : '';
        $model = !empty($values['mb_model']) ? get_the_title(esc_attr($values['mb_model'][0])) : '';

        switch ($column) {
            case 'brand':
                echo $brand;
                break;
            case 'model':
                echo $model;
                break;
        }
    }

}
