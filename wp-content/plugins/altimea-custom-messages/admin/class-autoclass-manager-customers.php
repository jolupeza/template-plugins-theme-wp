<?php

namespace Autoclass_Manager\Admin;

class Autoclass_Manager_Customers
{
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type customers.
     */
    public function cd_mb_customers_add()
    {
        add_meta_box(
            'mb-customers-id', 'Datos del Cliente', array($this, 'render_mb_customers'), 'customers', 'normal', 'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_customers()
    {
        require_once plugin_dir_path(__FILE__).'partials/autoclass-mb-customers.php';
    }

    public function custom_columns_customers($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Nombre'),
            'email' => __('Correo electrónico'),
            'typeDoc' => __('Tipo Documento'),
            'numDoc' => __('Número Documento'),
            'date' => __('Fecha'),
        );

        return $columns;
    }

    public function custom_column_customers($column)
    {
        global $post;

        // Setup some vars
        $edit_link = get_edit_post_link($post->ID);
        $post_type_object = get_post_type_object($post->post_type);
        $can_edit_post = current_user_can('edit_post', $post->ID);
        $values = get_post_custom($post->ID);
        $name = !empty($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
        $apePat = !empty($values['mb_apePat']) ? esc_attr($values['mb_apePat'][0]) : '';
        $apeMat = !empty($values['mb_apeMat']) ? esc_attr($values['mb_apeMat'][0]) : '';
        $fullName = "$name $apePat $apeMat";
        $email = !empty($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
        $typeDoc = !empty($values['mb_typeDoc']) ? esc_attr($values['mb_typeDoc'][0]) : '';
        $numDoc = !empty($values['mb_numDoc']) ? esc_attr($values['mb_numDoc'][0]) : '';

        switch ($column) {
            case 'name':
                // Display the name
                if (!empty($fullName)) {
                    if($can_edit_post && $post->post_status != 'trash') {
                        echo '<a class="row-title" href="' . $edit_link . '" title="' . esc_attr(__('Editar este elemento')) . '">' . $fullName . '</a>';
                    } else {
                        _e($fullName);
                    }
                }

                // Add admin actions
                $actions = array();
                if ($can_edit_post && 'trash' != $post->post_status) {
                    $actions['edit'] = '<a href="' . get_edit_post_link($post->ID, true) . '" title="' . esc_attr(__( 'Editar este elemento')) . '">' . __('Editar') . '</a>';
                }

                if (current_user_can('delete_post', $post->ID)) {
                    if ('trash' == $post->post_status) {
                        $actions['untrash'] = "<a title='" . esc_attr(__('Restaurar este elemento desde la papelera')) . "' href='" . wp_nonce_url(admin_url(sprintf($post_type_object->_edit_link . '&amp;action=untrash', $post->ID)), 'untrash-post_' . $post->ID) . "'>" . __('Restaurar') . "</a>";
                    } elseif(EMPTY_TRASH_DAYS) {
                        $actions['trash'] = "<a class='submitdelete' title='" . esc_attr(__('Mover este elemento a la papelera')) . "' href='" . get_delete_post_link($post->ID) . "'>" . __('Papelera') . "</a>";
                    }

                    if ('trash' == $post->post_status || !EMPTY_TRASH_DAYS) {
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr(__('Borrar este elemento permanentemente')) . "' href='" . get_delete_post_link($post->ID, '', true) . "'>" . __('Borrar permanentemente') . "</a>";
                    }
                }

                $html = '<div class="row-actions">';
                if (isset($actions['edit'])) {
                    $html .= '<span class="edit">' . $actions['edit'] . ' | </span>';
                }
                if (isset($actions['trash'])) {
                    $html .= '<span class="trash">' . $actions['trash'] . '</span>';
                }
                if (isset($actions['untrash'])) {
                    $html .= '<span class="untrash">' . $actions['untrash'] . ' | </span>';
                }
                if (isset($actions['delete'])) {
                    $html .= '<span class="delete">' . $actions['delete'] . '</span>';
                }
                $html .= '</div>';

                echo $html;
                break;
            case 'email':
                echo $email; break;
            case 'typeDoc':
                _e(strtoupper($typeDoc)); break;
            case 'numDoc':
                _e($numDoc); break;
        }
    }

    public function customers_button_view_edit($views)
    {
        echo '<p>'
            . '<a href="' . plugin_dir_url(dirname(__FILE__)) . 'customers/generateExcel"'
            . ' id="generate-excel" class="button button-primary">Generar excel</a>'
            . '</p>';
    }
}
