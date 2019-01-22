<?php

namespace Altimea_Custom_Messages\Admin;

/**
 * Maintains the various types of messages for the plugin are maintained by this
 * base class.
 *
 * @package Altimea_Custom_Messages
 */

/**
 * Maintains the various types of messages for the plugin are maintained by this
 * base class. All message types are to be subclassed and identified by a type.
 *
 * @package Altimea_Custom_Messages
 */

class Settings_Message
{
    /**
     * The array of messages used to collect the types of messages managed by this
     * class. This includes both success, error, and warning messages.
     *
     * @access private
     * @var    array
     */
    private $messages;

    /**
     * Instantiates this class by setting up the array of messages to identify
     * each type of collection of messages.
     */
    public function __construct()
    {
        $this->messages = [
            'success' => [],
            'error' => [],
            'warning' => []
        ];
    }
    
    /**
     * Add a single message with the specified type to the collection of messages to display.
     *
     * @param string $type    The type of message to display.
     * @param string $message The message to display.
     */
    public function addMessage($type, $message)
    {
        $message = sanitize_text_field($message);
        
        if (in_array($message, $this->messages[$type], true)) return;
        
        array_push($this->messages[$type], $message);
    }
    
    /**
     * Retrieves all of the messages of the specified type and renders it ot the display.
     *
     * @param string $type The type of message(s) to retrieve from the collection of messages.
     */
    public function getMessages($type)
    {
        if (empty($this->messages[$type])) return;

        $html = "<div class='notice notice-$type is-dismissible'>";
        $html .= '<ul>';
        foreach ($this->messages[$type] as $message) {
            $html .= "<li>$message</li>";
        }
        $html .= '</ul>';
        $html .= '</div><!-- .notice-$type -->';

        $allowed_html = array(
            'div' => array(
                'class' => array(),
            ),
            'ul' => array(),
            'li' => array(),
        );

        echo wp_kses($html, $allowed_html);
    }
    
    /**
     * Retrieves all of the messages that are stored in the message collections. Renders
     * them to the display.
     */
    public function getAllMessages()
    {
        foreach ($this->messages as $type => $message) {
            $this->getMessages($type);
        }
    }

}
