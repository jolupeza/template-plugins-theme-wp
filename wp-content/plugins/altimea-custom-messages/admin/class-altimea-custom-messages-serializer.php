<?php

namespace Altimea_Custom_Messages\Admin;

use Altimea_Custom_Messages\Admin\Settings_Messenger;

/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * @package Altimea_Custom_Messages
 */

/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * This will also check the specified nonce and verify that the current user has
 * permission to save the data.
 *
 * @package Altimea_Custom_Messages
 */
class Altimea_Custom_Messages_Serializer
{
    /**
     * Labels indicate allowed in custom fields.
     *
     * @var array
     */
    protected $allowed;
    
    protected $messenger;

    public function __construct(Settings_Messenger $messenger)
    {
        $this->allowed = array(
            'p' => array(
                'style' => array(),
            ),
            'a' => array(// on allow a tags
                'href' => array(),
                'target' => array(),
            ),
            'ul' => array(
                'class' => array(),
            ),
            'ol' => array(),
            'li' => array(
                'style' => array(),
            ),
            'strong' => array(),
            'br' => array(),
            'span' => [
                'class' => [],
            ],
        );
        
        $this->messenger = $messenger;
    }

    public function init()
    {
        add_action( 'admin_post', array( $this, 'save' ) );
    }

    public function save()
    {
        $this->messenger->addErrorMessage('No esta autorizado para realizar cambios en esta sección');

        // First, validate the nonce and verify the user as permission to save.
        if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
            $this->messenger->addErrorMessage('No esta autorizado para realizar cambios en esta sección');
        }

        if ( null !== wp_unslash( $_POST['facebook_id'] )) {
            $value = sanitize_text_field($_POST['facebook_id']);
            update_option('facebook_id', $value);
        }
        
//        $this->messenger->getAllMessages();

        $this->redirect();
    }

    /**
     * Determines if the nonce variable associated with the options page is set
     * and is valid.
     *
     * @access private
     *
     * @return boolean False if the field isn't set or the nonce value is invalid;
     *                       otherwise, true.
     */
    private function has_valid_nonce()
    {
        // If the field isn't even in the $_POST, then it's invalid.
        if ( ! isset( $_POST['altimea-custom-message'] ) ) { // Input var okay.
            return false;
        }

        $field  = wp_unslash( $_POST['altimea-custom-message'] );
        $action = 'altimea-custom-messages-settings-save';

        return wp_verify_nonce( $field, $action );
    }

    /**
     * Redirect to the page from which we came (which should always be the
     * admin page. If the referred isn't set, then we redirect the user to
     * the login page.
     *
     * @access private
     */
    private function redirect()
    {
        // To make the Coding Standards happy, we have to initialize this.
        if (!isset($_POST['_wp_http_referer'])) { // Input var okay.
            $_POST['_wp_http_referer'] = wp_login_url();
        }

        // Sanitize the value of the $_POST collection for the Coding Standards.
        $url = sanitize_text_field(
            wp_unslash($_POST['_wp_http_referer']) // Input var okay.
        );

        // Finally, redirect back to the admin page.
        wp_safe_redirect(urldecode($url));
        exit;
    }

}