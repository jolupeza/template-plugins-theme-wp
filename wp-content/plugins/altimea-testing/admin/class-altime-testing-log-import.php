<?php

namespace AltimeaTesting\Admin;

use AltimeaTesting\Admin\Modules\ActivityLog;

class AltimeTestingLogImport
{
    /**
     * @var ActivityLog
     */
    private $activityLog;

    public function __construct(ActivityLog $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    public function uploadLog()
    {
        // Listen for form submission
        if (empty($_POST['action']) || 'import-logs' !== $_POST['action']) {
            return;
        }

        // Check permissions and nonces
        if (!current_user_can('manage_options')) {
            wp_die('Ocurrió un error :(');
        }

        check_admin_referer('altimea-testing-import-logs', '_wplnonce');

        // Perform checks on file
        // Sanity check
        if (empty($_FILES['altimea_import'])) {
            wp_die('No file found :(');
        }

        $file = $_FILES['altimea_import'];

        // It is of the expected type?
        if ($file['type'] != "text/xml") {
            wp_die(sprintf(
                __("There was an error importing the logs. File type detected: '%s'. 'text/xml' expected", 'altimeatesting'),
                $file['type']
            ));
        }

        // Impose a limit on the size of the uploaded file. Max 2097152 bytes = 2MB
        if ($file['size'] > 2097152) {
            $size = size_format($file['size'], 2);
            wp_die(sprintf(__( 'File size too large (%s). Maximum 2MB', 'altimeatesting' ), $size));
        }

        if ($file['error'] > 0) {
            wp_die(sprintf(__( "Error encountered: %d", 'altimeatesting' ), $file["error"]));
        }

        /* If we've made it this far then we can import the data */
        $imported = $this->import($file['tmp_name']);

        /* Everything is complete, now redirect back to the page */
        wp_redirect(add_query_arg('imported', $imported));
        exit();
    }

    private function import($file)
    {
        // Pare file
        $logs = $this->parse($file);

        // No logs found ? - then aborted
        if (!$logs) {
            return 0;
        }

        // Initialises a variable storing the number of logs successfully imported.
        $imported = 0;

        // Go through each log
        foreach ($logs as $logId => $log) {
            /*
             * Check if the log already exists:
             * We'll just check the date and the user ID, but we could check other details
             * if we extended our wptuts_get_logs() API
             */
            $exists = $this->activityLog->getLogs([
                'user_id' => $log['user_id'],
                'since' => mysql2date('G', $log['activity_date'], false),
                'until' => mysql2date('G', $log['activity_date'], false),
            ]);

            // If it exists, don't import it
            if ($exists) {
                continue;
            }

            // Insert the log
            $successful = $this->activityLog->insert([
                'user_id' => $log['user_id'],
                'date' => mysql2date('G', $log['activity_date'], false),
                'object_id' => $log['object_id'],
                'object_type' => $log['object_type'],
                'activity' => $log['activity'],
                'activity_date' => $log['activity_date'],
            ]);

            if ($successful) {
                $imported++;
            }
        }

        return $imported;
    }

    private function parse($file)
    {
        // Load the xml file
        $xml = simplexml_load_file($file);

        // halt if loading produces an error
        if (!$xml) {
            return false;
        }

        // Initial logs array
        $logs = array();
        foreach ($xml->xpath('/logs/item') as $logObj) {
            $log = $logObj->children();
            $logId = (int) $log->log_id;

            $logs[$logId] = [
                'user_id' => (int) $log->user_id,
                'object_id' => (int) $log->object_id,
                'object_type' => (string) $log->object_type,
                'activity' => (string) $log->activity,
                'activity_date' => (string) $log->activity_date,
            ];
        }

        return $logs;
    }

    public function importNotice()
    {
        // Was an import attempted and are we on the correct admin page?
        if (!isset($_GET['imported']) || 'tools_page_altimea_import' !== get_current_screen()->id) {
            return;
        }

        $imported = intval($_GET['imported']);

        if (1 == $imported) {
            printf('<div class="updated"><p>%s</p></div>', __('1 log successfully imported', 'altimeatesting' ) );
        } elseif (intval($_GET['imported'])) {
            printf(
                '<div class="updated"><p>%s</p></div>',
                sprintf(
                    __( '%d logs successfully imported', 'altimeatesting'),
                    $imported
                )
            );
        } else {
            printf('<div class="error"><p>%s</p></div>', __('No logs were imported', 'altimeatesting'));
        }
    }
}
