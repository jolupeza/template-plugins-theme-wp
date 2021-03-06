<?php

namespace CustomMessages;

/**
 * Looks at the incoming class or interface determines if it's valid.
 *
 * @package Altimea_Custom_Messages\Inc
 */

/**
 * Looks at the incoming class or interface determines if it's valid.
 *
 * @package Altimea_Custom_Messages\Inc
 */
class NamespaceValidator
{
    /**
     * Yields the deciding factor if we can proceed with the rest of our code our not.
     *
     * @param  string $filename The path to the file that we're attempting to load.
     * @return bool             Whether or not the specified file is in the correct namespace.
     */
    public function isValid($filename)
    {
        return (0 === strpos($filename, 'Altimea_Custom_Messages'));
    }
}
