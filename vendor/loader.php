<?php 

/**
 * File loader.php
 *
 * Will load all vendors
 *
 * @category Root
 * @package Root
 * @license http://opensource.org/licenses/MIT
 * @link /
 * @since Version 0.0.1
 * @version 0.0.1
 */
define( 'DS', DIRECTORY_SEPARATOR );
define( 'CONFPATH', join( DS, array(dirname(__DIR__), 'config')) );
define( 'PARTPATH', join( DS, array(dirname(__DIR__), 'parts')) );

if( $dir = opendir( __DIR__ ) ){
    while( false !== ($file = readdir( $dir )) ) {
        if( is_dir(__DIR__ . DS . $file) && $file !== '.' && $file !== '..' ){
            require_once join(DS, array($file, 'autoload.php'));
        }
    }
    closedir($dir);  
}