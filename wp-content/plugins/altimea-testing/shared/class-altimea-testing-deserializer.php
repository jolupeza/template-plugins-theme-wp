<?php

namespace AltimeaTesting\Shared;

/**
 * Retrieves information from the database.
 *
 * @package AltimeaTesting
 */

/**
 * Retrieves information from the database.
 *
 * This requires the information being retrieved from the database should be
 * specified by an incoming key. If no key is specified or a value is not found
 * then an empty string will be returned.
 *
 * @package AltimeaTesting
 *
 */

class AltimeaTestingDeserializer
{
    public function get_value( $option_key )
    {
        return get_option( $option_key, '' );
    }
}