<?php

namespace Altimea_Custom_Messages\Admin;

use Altimea_Custom_Messages\Admin\Settings_Message;

/**
 * Represents the mechanism responsible for displaying the settings messages.
 *
 * @package Altimea_Custom_Messages
 */

/**
 * Represents the mechanism responsible for displaying the settings messages. This
 * includes all success, warning, and error message types.
 *
 * @package Altimea_Custom_Messages
 */
class Settings_Messenger
{
    /**
     * Refers to an instance of a settings message as defined in this class.
     *
     * @access private
     * @var Settings_Message $message An instance of the settings message.
     */
    private $message;
    
    /**
     * Initializes this class by creating an instance of a Settings Message.
     */
    public function __construct()
    {
        $this->message = new Settings_Message();
    }
    
    /**
     * Initializes the class by associated the `getAllMessages` hook with the custom
     * hook defined elsewhere in the codebase.
     */
    public function init()
    {
        add_action( 'altimea_settings_messages', array( $this, 'getAllMessages' ) );
    }
    
    /**
     * Adds the specified message with a success attribute to the collection of messages.
     *
     * @param string $message The message to add to the collection of messages.
     */
    public function addSuccessMessage($message)
    {
        $this->addMessage('success', $message);
    }
    
    /**
     * Adds the specified message with a warning attribute to the collection of messages.
     *
     * @param string $message The message to add to the collection of messages.
     */
    public function addWarningMessage($message)
    {
        $this->addMessage('warning', $message);
    }
    
    /**
     * Adds the specified message with a error attribute to the collection of messages.
     *
     * @param string $message The message to add to the collection of messages.
     */
    public function addErrorMessage($message)
    {
        $this->addMessage('error', $message);
    }
    
    /**
     * Retrieves all of the success messages and displays them on the front-end.
     */
    public function getSuccessMessages()
    {
        echo esc_html($this->getMessages('success'));
    }
    
    /**
     * Retrieves all of the warning messages and displays them on the front-end.
     */
    public function getWarningMessages()
    {
        echo esc_html($this->getMessages('warning'));
    }
    
    /**
     * Retrieves all of the error messages and displays them on the front-end.
     */
    public function getErrorMessages()
    {
        echo esc_html($this->getMessages('error'));
    }
    
    /**
     * A convenience method for retrieving all of the messages.
     */
    public function getAllMessages()
    {
        $this->message->getAllMessages();
    }
    
    /**
     * Adds the message with the specified type to the collection of messages.
     *
     * @access private
     *
     * @param string $type    The type of message to add (either success, warning, or error).
     * @param string $message The message to add to the collection of messages.
     */
    private function addMessage($type, $message)
    {
        $this->message->addMessage($type, $message);
    }
    
    /**
     * Retrieves all of the messages with the specified type.
     *
     * @access private
     *
     * @param string $type    The type of message to retrieve (either success, warning, or error).
     */
    private function getMessages($type)
    {
        return $this->message->getMessages($type);
    }

}
