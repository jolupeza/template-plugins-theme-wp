<?php

namespace AltimeaTesting\Includes;

use AltimeaTesting\Admin\AltimeaTestingAdmin;
use AltimeaTesting\Admin\Modules\ActivityLog;

/**
 * Fired during plugin activation
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    AltimeaTesting
 * @subpackage AltimeaTesting/includes
 * @author     Altimea <apps@altimea.com>
 */
class AltimeaTestingActivator
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $altimeaTesting    The ID of this plugin.
     */
    private $altimeaTesting;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * @var \AltimeaTesting\Admin\Modules\ActivityLog
     */
    private $activityLog;

    public function __construct()
    {
        $this->altimeaTesting = 'altimea-testing';
        $this->version = '1.0.0';
    }

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     * @return Void
     */
    public function activate()
    {
        $this->getActivityLog()->createTables();
    }

    private function getActivityLog()
    {
        if ($this->activityLog) {
            return $this->activityLog;
        }

        return $this->activityLog = new ActivityLog($this->altimeaTesting, $this->version);
    }
}
