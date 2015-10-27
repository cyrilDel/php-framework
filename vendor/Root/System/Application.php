<?php


/**
 * File Application.php
 *
 * PHP version 5
 *
 * @category System
 * @package Root
 * @license http://opensource.org/licenses/MIT
 * @link /
 * @since Version 0.0.1
 * @version 0.0.1
 */

namespace Root\System;

/**
* This class manages the Application himself
*
* @category System
* @package Root
* @since Version 0.0.1
* @version 0.0.1 
* @author Cyrl Delage <cdelage.dev@gmail.com>
*/
class Application
{
	/**
	* Main config array
	* @var array
	*/
	protected $config = array();

	/**
	* Constructor of the class
	*
	* @param array $config The config array
	* @since Version 0.0.1
	* @version 0.0.1
	*/
	public function __construct( $config = array() )
	{
		if( is_array($config) ){
			$this->config = $config;
		}
	}

    /**
     * Call a page from the request uri
     *
     * @param string $uri The requested uri
     * @return self
     * @since Version 0.0.1
     * @version 0.0.1
     */
public function call($uri = null)
{
    if( is_null($uri) ){
        $uri = $_SERVER['REQUEST_URI'];
    }
    if( !is_string($uri) ){
        throw new \Exception("The requested URI is not a string.", 1);
    }
    $routes = $this->config['routes'];
    /**
     * If the path exists in the config array
     */
    if( isset($routes[$uri]) ){
        $index = $uri;
    } else if( isset( $routes['^(.*)$'] ) ){
        $index = '^(.*)$';
    } else {
        $index = 0;
    }
    /**
     * We load the file from the rawcall or the call
     */
    if( 
        isset( $routes[$index]['rawcall'] ) &&
        false !== $routes[$index]['rawcall'] && 
        file_exists( PARTPATH . DS . $routes[$index]['rawcall'] )
    ){
        include_once PARTPATH . DS . $routes[$index]['rawcall'];
    }else if(
        isset( $routes[$index]['call'] ) &&
        false !== $routes[$index]['call']
    ){
        include_once PARTPATH . DS . $routes[$index]['call'];                
    }
    return $this;
}

/**
 * Start an instance Application
 *
 * @return Application
 * @since Version 0.0.1
 * @version 0.0.1
 */
public static function _start()
{
    if( !defined( 'CONFPATH' ) ){
        throw new \Exception("There's no config path defined.", 1);
    } else if( !defined( 'PARTPATH' ) ){
        throw new \Exception("There's no parts path defined.", 1);
    }
    $config = array();
    if( $dir = opendir( CONFPATH ) ){
        while( false !== ($file = readdir( $dir )) ){
            if( !is_dir(__DIR__ . DS . $file) && $file !== '.' && $file !== '..' ){
                $config = array_merge_recursive(
                    $config,
                    include_once CONFPATH . DS . $file
                );
            }
        }
        closedir($dir);       
    } else {
        throw new \Exception("Impossible to access the config path.", 1);            
    }
    $app = new self( $config );
    $app->call();
    return $app;
}
}