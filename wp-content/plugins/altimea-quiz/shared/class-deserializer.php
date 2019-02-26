<?php

namespace AltimeaQuiz\Shared;

/**
 * Retrieves information from the database.
 *
 * @package AltimeaQuiz
 */

/**
 * Retrieves information from the database.
 *
 * This requires the information being retrieved from the database should be
 * specified by an incoming key. If no key is specified or a value is not found
 * then an empty string will be returned.
 *
 * @package AltimeaQuiz
 *
 */

class Deserializer
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get_value( $option_key )
    {
        return get_option( $option_key, '' );
    }
}
