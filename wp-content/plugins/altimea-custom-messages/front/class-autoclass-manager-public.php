<?php

namespace Autoclass_Manager\Front;

use Autoclass_Manager\Shared\Autoclass_Manager_Deserializer;

/**
 * The Autoclass Manager Public defines all functionality for the public-facing
 * sides of the plugin.
 */

/**
 * The Autoclass Manager Public defines all functionality for the public-facing
 * sides of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since    1.0.0
 */
class Autoclass_Manager_Public
{
    /**
     *
     * @var Autoclass_Manager\Shared\Autoclass_Manager_Deserializer
     */
    private $deserializer;

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version, Autoclass_Manager_Deserializer $deserializer)
    {
        $this->version = $version;

        $this->deserializer = $deserializer;

        add_action('wp_ajax_register_customer', array(&$this, 'register_customer_callback'));
        add_action('wp_ajax_nopriv_register_customer', array(&$this, 'register_customer_callback'));
    }

    public function register_customer_callback()
    {        
        $nonce = $_POST['nonce'];
        $data = [];
        $result = [
            'result' => false,
            'msg' => '',
            'content' => ''
        ];

        if ( !wp_verify_nonce( $nonce, 'autoclassajax-nonce') ) {
            die( 'Acceso denegado' );
        }

        if ( ! $this->validateData($_POST) ) {
            $result['msg'] = 'Por favor verifique que ha completado correctamente los datos solicitados y vuelva a intentarlo.';

            echo json_encode($result); die();
        }

        $data['name']  = sanitize_text_field($_POST['name']);
        $data['apePat']  = sanitize_text_field($_POST['apePat']);
        $data['apeMat']  = sanitize_text_field($_POST['apeMat']);
        $data['email'] = sanitize_email($_POST['email']);
        $data['typeDoc'] = sanitize_text_field($_POST['typeDoc']);
        $data['numDoc'] = sanitize_text_field($_POST['numDoc']);
        $data['phone'] = sanitize_text_field($_POST['phone']);
        $data['car'] = (int)sanitize_text_field($_POST['car']);
        
        $carTitle = sanitize_text_field($_POST['carTitle']);
        
        $this->saveCustomer($data);

        $this->sendEmailCustomer($data);

        $this->sendEmailCustomerAdmin($data, $carTitle);

        $result['result'] = true;
        $result['msg'] = $this->deserializer->get_value('email-response');

        echo json_encode($result); die();
    }

    private function validateData($data)
    {
        return !empty($data['name'])
                && !empty($data['apePat'])
                && !empty($data['apeMat'])
                && !empty($data['car'])
                && !empty($data['email']) && is_email($data['email'])
                && !empty($data['typeDoc'])
                && ($data['typeDoc'] === 'dni' || $data['typeDoc'] === 'ce')
                && !empty($data['numDoc']) && preg_match('/^[0-9]+$/', $data['numDoc'])
                && !empty($data['phone']) && preg_match('/^[0-9]+$/', $data['phone'])
                && (strlen($data['phone']) > 6 || strlen($data['phone']) < 10);
    }

    private function getDataSubject($subject)
    {
        return get_term_by('id', $subject, 'subjects');
    }

    private function saveCustomer($data)
    {
        $customer_id = wp_insert_post([
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'customers'
        ]);

        add_post_meta($customer_id, 'mb_name', $data['name']);
        add_post_meta($customer_id, 'mb_apePat', $data['apePat']);
        add_post_meta($customer_id, 'mb_apeMat', $data['apeMat']);
        add_post_meta($customer_id, 'mb_email', $data['email']);
        add_post_meta($customer_id, 'mb_phone', $data['phone']);
        add_post_meta($customer_id, 'mb_typeDoc', $data['typeDoc']);
        add_post_meta($customer_id, 'mb_numDoc', $data['numDoc']);
        add_post_meta($customer_id, 'mb_car', $data['car']);
    }

    private function sendEmailCustomer($data)
    {
        if (file_exists(plugin_dir_path(__FILE__) . 'templates/template-email-customer.php')) {
            $emailResponse = $this->deserializer->get_value('email-response');

            ob_start();

            include plugin_dir_path(__FILE__) . 'templates/template-email-customer.php';

            $content = ob_get_contents();

            ob_get_clean();

            $headers[] = "From: Autoclass";
            // $headers[] = "Reply-To: $email";
            $headers[] = "Content-type: text/html; charset=utf-8";
            $subjectEmail = $this->deserializer->get_value('subject-email');

            wp_mail($data['email'], $subjectEmail, $content, $headers);
        }
    }

    private function sendEmailCustomerAdmin($data, $carTitle)
    {
        if (file_exists(plugin_dir_path(__FILE__) . 'templates/template-email-customerAdmin.php')) {
            $receiverEmail = $this->getAdminEmail();
            $car = $carTitle;

            ob_start();

            include plugin_dir_path(__FILE__) . 'templates/template-email-customerAdmin.php';

            $content = ob_get_contents();

            ob_get_clean();

            $headers[] = "From: Autoclass";
            // $headers[] = "Reply-To: $email";
            $headers[] = "Content-type: text/html; charset=utf-8";
            $subjectEmail = $this->deserializer->get_value('subject-email');

            wp_mail($receiverEmail, $subjectEmail, $content, $headers);
        }
    }

    private function getAdminEmail()
    {
        $receiverEmail = $this->deserializer->get_value('admin-email');

        //If none is specified, get the WP admin email
        if (!isset($receiverEmail) || empty($receiverEmail)) {
            $receiverEmail = get_option('admin_email');
        }

        return $receiverEmail;
    }
}
