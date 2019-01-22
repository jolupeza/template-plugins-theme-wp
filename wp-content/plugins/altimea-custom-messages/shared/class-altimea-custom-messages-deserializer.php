<?php

namespace Altimea_Custom_Messages\Shared;

/**
 * Retrieves information from the database.
 *
 * @package Altimea_Custom_Messages
 */

/**
 * Retrieves information from the database.
 *
 * This requires the information being retrieved from the database should be
 * specified by an incoming key. If no key is specified or a value is not found
 * then an empty string will be returned.
 *
 * @package Altimea_Custom_Messages
 *
 */

class Altimea_Custom_Messages_Deserializer
{
    public function get_value( $option_key )
    {
        return get_option( $option_key, '' );
    }
}