<?php

namespace Altimea_Custom_Messages\Admin;

use Altimea_Custom_Messages\Shared\Altimea_Custom_Messages_Deserializer as Deserializer;

/**
 * Creates the submenu page for the plugin.
 *
 * @package Altimea_Custom_Messages
 */
 
/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package Altimea_Custom_Messages
 */
class Altimea_Custom_Messages_Submenu_Page
{
    /**
     *
     * @var \Altimea_Custom_Messages\Shared\Altimea_Custom_Messages_Deserializer
     */
    private $deserializer;

    /**
     * 
     * @param Deserializer $deserializer
     */
    public function __construct(Deserializer $deserializer)
    {
        $this->deserializer = $deserializer;
    }
 
    /**
     * This function renders the contents of the page associated with the Submenu
     * that invokes the render method. In the context of this plugin, this is the
     * Submenu class.
     */
    public function render()
    {
        $facebookId = $this->deserializer->get_value('facebook_id');
        
        require_once plugin_dir_path(__FILE__) . 'views/settings-manager.php';
    }
}