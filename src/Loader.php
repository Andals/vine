<?php
/**
* @file Loader.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine;

/**
    * Used in app process
 */
class Loader
{/*{{{*/
    const KEY_REQUEST = 'request';
    const KEY_ROUTER  = 'router';

    private $container = null;

    private static $instances = array();

    private function __construct()
    {/*{{{*/
        $this->container = new \Vine\Container\Obj();
    }/*}}}*/

    /**
        * Singleton
        *
        * @return \Vine\Loader
     */
    public static function getInstance()
    {/*{{{*/
        $cls = get_called_class();
        if(!isset(self::$instances[$cls]) || !self::$instances[$cls] instanceof static)
        {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }/*}}}*/

    /**
        * Set request instance
        *
        * @param \Vine\Contract\Request $request
        *
        * @return 
     */
    public function setRequest(\Vine\Contract\Request $request)
    {/*{{{*/
        $this->container->add($request, self::KEY_REQUEST);
    }/*}}}*/

    /**
        * Get request instance
        *
        * @return \Vine\Contract\Request
     */
    public function loadRequest()
    {/*{{{*/
        return $this->container->get(self::KEY_REQUEST);
    }/*}}}*/

    /**
        * Set router instance
        *
        * @param \Vine\Contract\Router $router
        *
        * @return 
     */
    public function setRouter(\Vine\Contract\Router $router)
    {/*{{{*/
        $this->container->add($router, self::KEY_ROUTER);
    }/*}}}*/

    /**
        * Get router instance
        *
        * @return \Vine\Contract\Router
     */
    public function loadRouter()
    {/*{{{*/
        return $this->container->get(self::KEY_ROUTER);
    }/*}}}*/

    /**
        * Load controller instance
        *
        * @param string $appName
        * @param string $moduleName
        * @param string $controllerName
        *
        * @return \Vine\Contract\Controller
     */
    public function loadController($appName, $moduleName, $controllerName)
    {/*{{{*/
        $clsName = '\\'.ucfirst($appName).'\Controller\\';
        $clsName.= ucfirst($moduleName).'\\'.ucfirst($controllerName);

        if (!class_exists($clsName)) {
            throw new \Vine\Error\Exception(\Vine\Error\Errno::E_CONTROLLER_CONTROLLER_NOT_EXISTS);
        }

        $controller = new $clsName();
        if (!$controller instanceof \Vine\Contract\Controller) {
            throw new \Vine\Error\Exception(\Vine\Error\Errno::E_COMMON_INVALID_INSTANCE,'controller must be an instance of \Vine\Contract\Controller');
        }

        return $controller;
    }/*}}}*/
}/*}}}*/
