<?php

namespace AltimeaTesting\Admin;

use AltimeaTesting\Admin\Modules\ActivityLog;

/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * @package AltimeaTesting
 */

/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * This will also check the specified nonce and verify that the current user has
 * permission to save the data.
 *
 * @package AltimeaTesting
 */
class AltimeaTestingDownload
{
    /**
     * @var ActivityLog
     */
    private $activityLog;

    public function __construct(ActivityLog $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    public function init()
    {
        add_action('admin_post', array($this, 'downloadLog'));
    }

    public function downloadLog()
    {
        /* Listen for form submission */
        if (empty($_POST['action']) || 'export-logs' !== $_POST['action']) {
            return;
        }

        /* Check permissions and nonces */
        if (!current_user_can('manage_options')) {
            wp_die('Ocurrió un error :(');
        }

        check_admin_referer('altimea-testing-export-logs-save', '_wplnonce');

        // Trigger download
        $this->exportLogs();
    }

    private function exportLogs($args = [])
    {
        // Query logs
        $logs = $this->activityLog->getLogs($args);

        // If there are not logs - abort
        if (!$logs) {
            return false;
        }

        // Create a file name
        $sitename = sanitize_key(get_bloginfo('name'));
        if (!empty($sitename)) {
            $sitename .= '.';
        }

        $filename = $sitename . 'altimea-logs' . date('Y-m-d') . '.xml';

        // Print header
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Type: text/xml; charset='.get_option('blog_charset'), true);

        /* Print comments */
        echo "<!-- This is a export of the wptuts log table -->\n";
        echo "<!-- (Demonstration purposes only) -->\n";
        echo "<!-- (Optional) Included import steps here... -->\n";

        echo '<logs>';
        foreach ( $logs as $log ) { ?>
            <item>
                <log_id><?php echo absint($log->log_id); ?></log_id>
                <activity_date><?php echo mysql2date( 'Y-m-d H:i:s', $log->activity_date, false ); ?></activity_date>
                <user_id><?php echo absint($log->user_id); ?></user_id>
                <object_id><?php echo absint($log->object_id); ?></object_id>
                <object_type><?php echo sanitize_key($log->object_type); ?></object_type>
                <activity><?php echo sanitize_key($log->activity); ?></activity>
            </item>
        <?php }
        echo '</logs>';

        /* Finished - now exit */
        exit();
    }

    /**
     * Wraps the passed string in a XML CDATA tag.
     *
     * @param string $string String to wrap in a XML CDATA tag.
     * @return string
     */
    private function wrap_cdata($string)
    {
        if ( seems_utf8( $string ) == false ) {
            $string = utf8_encode( $string );
        }

        return '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', $string ) . ']]>';
    }
}
