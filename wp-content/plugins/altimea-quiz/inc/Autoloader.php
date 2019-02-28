<?php

namespace Quiz;

/**
 * Dynamically loads the class attempting to be instantiated elsewhere in the
 * plugin.
 *
 * @package AltimeaTesting\Inc
 */

/**
 * The primary point of entry for the autoloading functionality. Uses a number of other classes
 * to work through the process of autoloading classes and interfaces in the project.
 *
 * @package AltimeaTesting\Inc
 */
class Autoloader
{
    /**
     * Verifies the file being passed into the autoloader is of the same namespace as the
     * plugin.
     *
     * @var NamespaceValidator
     */
    private $namespaceValidator;
    
    /**
     * Uses the fully-qualified file path ultimately returned from the other classes.
     *
     * @var FileRegistry
     */
    private $fileRegistry;
    
    /**
     * Creates an instance of this class by instantiating the NamespaceValidator and the
     * FileRegistry.
     */
    public function __construct()
    {
        $this->namespaceValidator = new NamespaceValidator();
        $this->fileRegistry = new FileRegistry();
    }
    
    /**
     * Attempts to load the specified filename.
     *
     * @param  string $filename The path to the file that we're attempting to load.
     */
    public function load($filename)
    {
        if ($this->namespaceValidator->isValid($filename)) {
            $this->fileRegistry->load($filename);
        }
    }
}
