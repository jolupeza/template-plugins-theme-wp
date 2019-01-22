<?php

namespace Autoclass_Manager\Admin;

class Autoclass_Manager_Sliders
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
     * associated with post type sliders.
     */
    public function cd_mb_sliders_add()
    {
        add_meta_box(
            'mb-sliders-id', 'Datos del Slide', array($this, 'render_mb_sliders'), 'sliders', 'normal', 'core'
        );
    }
    
    public function cd_mb_sliders_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (empty(filter_input(INPUT_POST, 'meta_box_nonce')) || !wp_verify_nonce(filter_input(INPUT_POST, 'meta_box_nonce'), 'sliders_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        $data = [
            'mb_link' => filter_input(INPUT_POST, 'mb_link'),
            'mb_target' => !empty(filter_input(INPUT_POST, 'mb_target')) ? 'on' : 'off',
        ];
        
        $this->updateCustomMeta($post_id, $data);
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
    
    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_sliders()
    {
        require_once plugin_dir_path(__FILE__).'partials/autoclass-mb-sliders.php';
    }
}
