<?php

namespace AltimeaTesting\Admin;

use AltimeaTesting\Shared\AltimeaTestingDeserializer;

/**
 * Creates the submenu page for the plugin.
 *
 * @package AltimeaTesting
 */

/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package AltimeaTesting
 */
class AltimeaTestingSubmenuPage
{
    /**
     * @var AltimeaTestingDeserializer
     */
    private $deserializer;

    public function __construct(AltimeaTestingDeserializer $deserializer)
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
        require_once plugin_dir_path(__FILE__) . 'views/settings-export.php';
    }
}
