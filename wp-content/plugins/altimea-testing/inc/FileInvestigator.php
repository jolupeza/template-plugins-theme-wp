<?php

namespace Testing;

/**
 * This class looks at the type of file that's being passed into the autoloader.
 *
 * @package AltimeaTesting\Inc
 */
 
/**
 * This class looks at the type of file that's being passed into the autoloader.
 *
 * It will determine if it's a class, an interface, or a namespace and return the fully-qualified
 * path name to the file so that it may be included.
 *
 * @package AltimeaTesting\Inc
 */
class FileInvestigator
{
    /**
     * Returns the fully-qualified path to the file based on the incoming filename.
     *
     * @param  string $filename The incoming filename based on the class or interface name.
     * @return string           The path to the file.
     */
    public function getFileType($filename)
    {
        $filePath = '';
        $fileParts = explode('\\', $filename);

        for ($i = 1; $i < count($fileParts); $i++) {
            $current = $fileParts[$i];

            $filePath .= $this->getFileName($fileParts, $current, $i);
            
            if (count($fileParts) - 1 !== $i) {
                $filePath = trailingslashit($filePath);
            }
        }

        return $filePath;
    }
    
    /**
     * Retrieves the location of part of the filename on disk based on the current index of the
     * array being examined.
     *
     * @access private
     * @param  array  $fileParts The array of all parts of the file name.
     * @param  string $current    The current part of the file to examine.
     * @param  int    $i          The current index of the array of $file_parts to examine.
     * @return string             The name of the file on disk.
     */
    private function getFileName($fileParts, $current, $i)
    {
        $filename = '';
        
        if (count($fileParts) - 1 === $i) {
            if ($this->isInterface($fileParts)) {
                $filename = $this->getInterfaceName($fileParts);
            } else {
                $filename = $this->getClassName($current);
            }
        } else {
            $filename = $this->getNamespaceName($current);
        }
        
        return $filename;
    }
    
    /**
     * Determines if the specified file being examined is an interface.
     *
     * @access private
     * @param  array $fileParts The parts of the filepath to examine.
     * @return bool              True if interface is contained in the filename; otherwise, false.
     */
    private function isInterface($fileParts)
    {
        return strpos(strtolower($fileParts[count($fileParts) - 1]), 'interface');
    }
    
    /**
     * Retrieves the filename of the interface based on the specified parts of the file passed
     * into the autoloader.
     *
     * @access private
     * @param  array $fileParts The array of parts of the file to examine.
     * @return string            The filename of the interface.
     */
    private function getInterfaceName($fileParts)
    {
        $interfaceName = preg_replace("@([A-Z])@", "-$1", $fileParts[count($fileParts) - 1]);
        $interfaceName = explode('-', strtolower(trim($interfaceName, '-')))[0];
        
        return "interface-$interfaceName.php";
    }
    
    /**
     * Generates the name of the class filename on disk.
     *
     * @access private
     * @param  string $current The current piece of the file name to examine.
     * @return string          The class filename on disk.
     */
    private function getClassName($current)
    {
        $current = preg_replace("@([A-Z])@", "-$1", $current);
        $current = strtolower(trim($current, '-'));

        return "class-$current.php";
    }
    
    /**
     * Creates a mapping of the namespace to the directory structure.
     *
     * @access private
     * @param  string $current The current part of the file to examine.
     * @return string          The path of the namespace mapping to the directory structure.
     */
    private function getNamespaceName($current)
    {
        $current = $current === 'Front' ? 'Public' : $current;
        return '/' . strtolower($current);
    }
}
