<?php
/**
 * Includes the file from the plugin.
 *
 * @package Altimea_Custom_Messages\Inc
 */

/**
 * This will use the fully qualified file path ultimately returned from the other classes
 * and will include it in the plugin.
 *
 * @package Altimea_Custom_Messages\Inc
 */
class FileRegistry 
{
    /**
     * This class looks at the type of file that's being passed into the autoloader.
     *
     * @var FileInvestigator
     */
    private $investigator;
    
    /**
     * Creates an instance of this class by creating an instance of the FileInvestigator.
     */
    public function __construct()
    {
        $this->investigator = new FileInvestigator();
    }
    
    /**
     * Uses the file investigator to retrieve the location of the file on disk. If found, then
     * it will include it in the project; otherwise, it will throw a WordPress error message.
     *
     * @param  string $filepath The path to the file on disk to include in the plugin.
     */
    public function load($filePath)
    {        
        $filePath = $this->investigator->getFileType($filePath);
        
        $filePath = rtrim(plugin_dir_path(dirname(__FILE__)), '/') . $filePath;
        
        if (file_exists($filePath)) {
            include_once $filePath;
        } else {
            wp_die(
                esc_html('The specified file does not exist.')
            );
        }
    }
}
