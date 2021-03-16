<?php namespace App\modules\files\libraries;

/**
 * FileManager
 *
 * Main class for using FileManager, instantiate this class and choose adaptee/driver.
 * This codes is using adapter pattern.
 * 
 * @package Factory
 * @author Gemblue
 */

class FileManagerFactory
{ 
    /** Driver whitelist .. */
    public $whitelists = [
        'Local' => \App\modules\files\libraries\LocalDriver::class,
        'S3' => \App\modules\files\libraries\S3Driver::class
    ];
    
    /**
     * Factory Method
     * 
     * This method responsible to generate file manager object.
     *  
     * @return void
     */
    public function __invoke(string $driver, array $options) 
    {
        if (!in_array($driver, array_keys($this->whitelists))) {
            die($driver .' driver is not supported.');
        }

        return new $this->whitelists[$driver]($options);
    }
}
