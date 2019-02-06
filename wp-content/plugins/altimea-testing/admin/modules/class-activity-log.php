<?php

namespace AltimeaTesting\Admin\Modules;

class ActivityLog
{
    private $altimeaTesting;
    private $version;

    public function __construct($altimeaTesting, $version)
    {
        $this->altimeaTesting = $altimeaTesting;
        $this->version = $version;
    }

    public function registerActivityLogTable()
    {
        global $wpdb;
        $wpdb->activity_log = "{$wpdb->prefix}activity_log";
    }

    public function createTables()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        global $charset_collate;

        $this->registerActivityLogTable();

        $sqlCreateTable = "CREATE TABLE {$wpdb->activity_log} (log_id bigint(20) unsigned NOT NULL auto_increment, user_id bigint(20) unsigned NOT NULL default '0', activity varchar(20) NOT NULL default 'updated', object_id bigint(20) unsigned NOT NULL default '0', object_type varchar(20) NOT NULL default 'post', activity_date datetime NOT NULL default '0000-00-00 00:00:00', PRIMARY KEY  (log_id), KEY user_id (user_id)) $charset_collate; ";

        dbDelta($sqlCreateTable);
    }

    /**
     * Inserts a log into the database
     *
     *@param $data array An array of key => value pairs to be inserted
     *@return int The log ID of the created activity log. Or WP_Error or false on failure.
     */
    public function insert($data = [])
    {
        global $wpdb;

        // Set default values
        $data = wp_parse_args($data, [
            'user_id' => get_current_user_id(),
            'date' => current_time('timestamp'),
        ]);

        // Check data validity
        if (!is_float($data['date']) || $data['date'] <= 0) {
            return 0;
        }

        //Convert activity date from local timestamp to GMT mysql format
        $data['activity_date'] = date_i18n('Y-m-d H:i:s', $data['date'], true);

        //Initialise column format array
        $columnFormats = $this->getLogTableColumns();

        // Force fields to lower case
        $data = array_change_key_case($data);

        // White list columns
        $data = array_intersect_key($data, $columnFormats);

        //Reorder $column_formats to match the order of columns given in $data
        $dataKeys = array_keys($data);
        $columnFormats = array_merge(array_flip($dataKeys), $columnFormats);

        $wpdb->insert($wpdb->activity_log, $data, $columnFormats);

        return $wpdb->insert_id;
    }

    /**
     * Updates an activity log with supplied data
     *
     *@param $logId int ID of the activity log to be updated
     *@param $data array An array of column=>value pairs to be updated
     *@return bool Whether the log was successfully updated.
     */
    public function update($logId, $data = [])
    {
        global $wpdb;

        //Log ID must be positive integer
        $logId = absint($logId);
        if (empty($logId)) {
            return false;
        }

        //Convert activity date from local timestamp to GMT mysql format
        if (isset($data['activity_date'])) {
            $data['activity_date'] = date_i18n('Y-m-d H:i:s', $data['date'], true);
        }

        //Initialise column format array
        $columnFormats = $this->getLogTableColumns();

        //Force fields to lower case
        $data = array_change_key_case($data);

        //White list columns
        $data = array_intersect_key($data, $columnFormats);

        //Reorder $column_formats to match the order of columns given in $data
        $datakeys = array_keys($data);
        $columnFormats = array_merge(array_flip($datakeys), $columnFormats);

        if (false === $wpdb->update($wpdb->activity_log, $data, ['log_id' => $logId], $columnFormats)) {
            return false;
        }

        return true;
    }

    /**
     * Retrieves activity logs from the database matching $query.
     * $query is an array which can contain the following keys:
     *
     * 'fields' - an array of columns to include in returned roles. Or 'count' to count rows. Default: empty (all fields).
     * 'orderby' - datetime, user_id or log_id. Default: datetime.
     * 'order' - asc or desc
     * 'user_id' - user ID to match, or an array of user IDs
     * 'since' - timestamp. Return only activities after this date. Default false, no restriction.
     * 'until' - timestamp. Return only activities up to this date. Default false, no restriction.
     *
     *@param $query array
     *@return array Array of matching logs. False on error.
     */
    public function getLogs($query = [])
    {
        global $wpdb;

        // Parse defaults
        $defaults = array(
            'fields'=> array(), 'orderby'=> 'datetime', 'order'=> 'desc', 'log_id' => false, 'user_id'=> false,
            'since'=> false, 'until'=> false, 'number'=> 10, 'offset'=> 0
        );

        $query = wp_parse_args($query, $defaults);

        /* Form a cache key from the query */
        $cacheKey = 'altimea_logs:' . md5(serialize($query));
        $cache = wp_cache_get($cacheKey);

        if (false !== $cache) {
            return $cache = apply_filters('altimea_get_logs', $cache, $query);
        }

        extract($query);

        /* SQL Select */
        //Whitelist of allowed fields
        $allowed_fields = $this->getLogTableColumns();

        if (is_array($fields)){
            //Convert fields to lowercase (as our column names are all lower case - see part 1)
            $fields = array_map('strtolower',$fields);

            //Sanitize by white listing
            $fields = array_intersect_key($allowed_fields, $fields);
        } else {
            $fields = strtolower($fields);
        }

        //Return only selected fields. Empty is interpreted as all
        // $wpdb->activity_log
        $table = $wpdb->prefix . 'users';

        if (empty($fields)) {
            $selectSql = "SELECT * FROM {$table}";
        } elseif ('count' == $fields) {
            $selectSql = "SELECT COUNT(*) FROM {$table}";
        } else {
            $selectSql = "SELECT ".implode(',',$fields)." FROM {$table}";
            //$selectSql = $wpdb->prepare($selectSql, );
        }

        dd($selectSql);

        /*SQL Join */
        //We don't need this, but we'll allow it be filtered (see 'wptuts_logs_clauses' )
        $joinSql = '';

        /* SQL Where */
        //Initialise WHERE
        $whereSql = 'WHERE 1=1';

        if (!empty($log_id)) {
            $whereSql .=  $wpdb->prepare(' AND log_id=%d', $log_id);
        }

        if (!empty($user_id)) {
            //Force $user_id to be an array
            if (!is_array($user_id)) {
                $user_id = array($user_id);
            }

            $user_id = array_map('absint',$user_id); //Cast as positive integers
            $user_id__in = implode(',',$user_id);
            $whereSql .=  " AND user_id IN($user_id__in)";
        }

        $since = absint($since);
        $until = absint($until);

        if (!empty($since)) {
            $whereSql .=  $wpdb->prepare(' AND activity_date >= %s', date_i18n( 'Y-m-d H:i:s', $since, true));
        }

        if (!empty($until)) {
            $whereSql .=  $wpdb->prepare(' AND activity_date <= %s', date_i18n( 'Y-m-d H:i:s', $until, true));
        }

        /* SQL Order */
        //Whitelist order
        $order = strtoupper($order);
        $order = ('ASC' == $order ? 'ASC' : 'DESC');

        switch ($orderby) {
            case 'log_id':
                $orderSql = "ORDER BY log_id $order";
                break;
            case 'user_id':
                $orderSql = "ORDER BY user_id $order";
                break;
            case 'datetime':
                //$orderSql = "ORDER BY activity_date $order";
                $orderSql = "ORDER BY user_registered $order";
            default:
                break;
        }

        /* SQL Limit */
        $offset = absint($offset); //Positive integer
        if ($number == -1) {
            $limitSql = "";
        } else {
            $number = absint($number); //Positive integer
            $limitSql = "LIMIT $offset, $number";
        }

        /* Filter SQL */
        $pieces = array('select_sql', 'join_sql', 'where_sql', 'order_sql', 'limit_sql');
        $clauses = apply_filters( 'altimea_logs_clauses', compact($pieces), $query );
        foreach ($pieces as $piece) {
            $$piece = isset($clauses[$piece]) ? $clauses[$piece] : '';
        }

        /* Form SQL statement */
        $sql = "$selectSql $whereSql $orderSql $limitSql";

        if ('count' == $fields) {
            return $wpdb->get_var($sql);
        }

        /* Perform query */
        $logs = $wpdb->get_results($sql);

        dd($logs);

        /* Add to cache and filter */
        wp_cache_add($cacheKey, $logs, '', 24*60*60);
        $logs = apply_filters('altimea_get_logs', $logs, $query);
        return $logs;
    }

    /**
     * Deletes an activity log from the database
     *
     *@param $logId int ID of the activity log to be deleted
     *@return bool Whether the log was successfully deleted.
     */
    public function delete($logId)
    {
        global $wpdb;

        //Log ID must be positive integer
        $logId = absint($logId);
        if (empty($logId)) {
            return false;
        }

        do_action('altimea_delete_log', $logId);
        $sql = $wpdb->prepare("DELETE from {$wpdb->activity_log} WHERE log_id = %d", $logId);

        if (!$wpdb->query($sql)) {
            return false;
        }

        do_action('altimea_deleted_log', $logId);

        return true;
    }

    public function activityLogUpgradeCheck()
    {
        //Version of currently activated plugin
        $currentVersion = $this->version;

        //Database version - this may need upgrading.
        $installedVersion = get_option('altimea_activity_log_version');

        if (!$installedVersion) {
            //No installed version - we'll assume its just been freshly installed
            add_option('altimea_activity_log_version', $currentVersion);
        } elseif ($installedVersion != $currentVersion) {
            /* If this is an old version, perform some updates. */

            //Installed version is before 1.1 - upgrade to 1.1
            if (version_compare('1.1', $installedVersion)) {
                // Code to upgrade to version 1.1
            }

            //Database is now up to date: update installed version to latest version
            update_option('altimea_activity_log_version', $currentVersion);
        }
    }

    private function getLogTableColumns()
    {
        return [
            'log_id' => '%d',
            'user_id' => '%d',
            'activity' => '%s',
            'object_id' => '%d',
            'object_type' => '%s',
            'activity_date' => '%s',
            'user_login' => '%s',
            'display_name' => '%s',
        ];
    }
}
