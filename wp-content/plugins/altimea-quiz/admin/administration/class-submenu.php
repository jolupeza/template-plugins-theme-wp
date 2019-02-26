<?php

namespace AltimeaQuiz\Admin\Administration;

use AltimeaQuiz\Includes\AltimeaQuizLoader;

/**
 * Creates the submenu item for the plugin.
 *
 * @package AltimeaQuiz
 */

/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package AltimeQuiz
 */

class Submenu
{
    /**
     * @var SubmenuPage
     */
    private $submenuPage;

    /**
     * @var AltimeaQuizLoader
     */
    private $loader;

    public function __construct(SubmenuPage $submenuPage, AltimeaQuizLoader $loader)
    {
        $this->submenuPage = $submenuPage;
        $this->loader = $loader;
    }

    /**
     * Adds a submenu for this plugin to the 'Tools' menu.
     */
    public function init()
    {
        $this->loader->add_action('admin_menu', $this, 'add_options_page');
    }

    public function add_options_page()
    {
        add_menu_page(
            'Altimea Quiz Settings',
            'Altimea Quiz Settings',
            'administrator',
            'quiz_settings',
            array($this->submenuPage, 'render')
        );
    }
}
