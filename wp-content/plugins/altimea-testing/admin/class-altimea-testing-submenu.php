<?php

namespace AltimeaTesting\Admin;

/**
 * Creates the submenu item for the plugin.
 *
 * @package AltimeaTesting
 */

/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package AltimeaTesting
 */

class AltimeaTestingSubmenu
{
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * @var AltimeaTestingSubmenuPage
     */
    private $submenuPage;

    private $domain;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string               $version            The version of this plugin.
     * @param      AltimeaTestingSubmenuPage $submenuPage   Instance the submenu page for the plugin.
     */
    public function __construct($version, AltimeaTestingSubmenuPage $submenuPage)
    {
        $this->version = $version;
        $this->submenuPage = $submenuPage;
        $this->domain = 'altimeatesting';
    }

    /**
     * Adds a submenu for this plugin to the 'Tools' menu.
     */
    public function init()
    {
        add_action('admin_menu', array($this, 'addOptionsPage'));
    }

    /**
     * Creates the submenu item and calls on the Submenu Page object to render
     * the actual contents of the page.
     */
    public function addOptionsPage()
    {
        add_management_page(
            __('Export Logs', $this->domain),
            __('Export Logs', $this->domain),
            'manage_options',
            'altimea-testing-export',
            array( $this->submenuPage, 'render' )
        );
    }
}
