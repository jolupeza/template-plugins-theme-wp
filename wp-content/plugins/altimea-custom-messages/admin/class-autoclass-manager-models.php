<?php

namespace Autoclass_Manager\Admin;

class Autoclass_Manager_Models
{
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type models.
     */
    public function cd_mb_models_add()
    {
        add_meta_box(
            'mb-models-id', 'Datos del Modelo', array($this, 'render_mb_models'), 'models', 'normal', 'core'
        );
    }
    
    public function cd_mb_models_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (empty(filter_input(INPUT_POST, 'meta_box_nonce')) || !wp_verify_nonce(filter_input(INPUT_POST, 'meta_box_nonce'), 'models_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        $data = [
            'mb_brand' => filter_input(INPUT_POST, 'mb_brand'),
        ];
        
        $this->updateCustomMeta($post_id, $data);
    }
    
    private function updateCustomMeta($postId, $data = array())
    {
        foreach ($data as $meta => $value) {
            if (!empty($value)) {
                update_post_meta($postId, $meta, esc_attr($value));
            } else {
                delete_post_meta($postId, $meta);
            }
        }
    }
    
    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_models()
    {
        require_once plugin_dir_path(__FILE__).'partials/autoclass-mb-models.php';
    }

    public function custom_columns_models($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Modelo'),
            'brand' => __('Marca'),
            'author' => __('Autor'),
            'date' => __('Fecha'),
        );

        return $columns;
    }
    
    public function custom_column_models($column)
    {
        global $post;

        // Setup some vars
        $values = get_post_custom($post->ID);

        switch ($column) {
            case 'brand':
                echo !empty($values['mb_brand']) ? get_the_title(esc_attr($values['mb_brand'][0])) : '';
                break;
        }
    }

}
