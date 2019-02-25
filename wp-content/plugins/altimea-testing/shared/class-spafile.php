<?php

namespace AltimeaTesting\Shared;

class Spafile
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getFilesSpa($type)
    {
        $pathSpa = plugin_dir_path(ALTIMEA_TESTING_FILE) . 'spa/dist/' . $type;
        $filesSpa = file_exists($pathSpa) ? scandir($pathSpa) : false;
        return $filesSpa ? array_values(array_filter(array_slice($filesSpa, 2), function ($file) {
            return ! strpos($file, '.map');
        })) : $filesSpa;
    }
}
