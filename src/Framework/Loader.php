<?php
/**
* @file Loader.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Framework;

/**
    * Used in app process
 */
class Loader
{/*{{{*/
    const KEY_REQUEST  = 'request';
    const KEY_ROUTER   = 'router';
    const KEY_RESPONSE = 'response';

    private $container = null;

    private static $instances = array();

    private function __construct()
    {/*{{{*/
        $this->container = new \Vine\Component\Container\Obj();
    }/*}}}*/

    /**
        * Singleton
        *
        * @return \Vine\Framework\Loader
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
        * @param \Vine\Component\Http\RequestInterface $request
        *
        * @return 
     */
    public function setRequest(\Vine\Component\Http\RequestInterface $request)
    {/*{{{*/
        $this->container->add($request, self::KEY_REQUEST);
    }/*}}}*/

    /**
        * Get request instance
        *
        * @return \Vine\Component\Http\RequestInterface
     */
    public function loadRequest()
    {/*{{{*/
        return $this->container->get(self::KEY_REQUEST);
    }/*}}}*/

    /**
        * Set response instance
        *
        * @param \Vine\Component\Http\ResponseInterface $response
        *
        * @return 
     */
    public function setResponse(\Vine\Component\Http\ResponseInterface $response)
    {/*{{{*/
        $this->container->add($response, self::KEY_RESPONSE);
    }/*}}}*/

    /**
        * Get response instance
        *
        * @return \Vine\Component\Http\ResponseInterface
     */
    public function loadResponse()
    {/*{{{*/
        return $this->container->get(self::KEY_RESPONSE);
    }/*}}}*/

    /**
        * Set router instance
        *
        * @param \Vine\Component\Routing\RouterInterface $router
        *
        * @return 
     */
    public function setRouter(\Vine\Component\Routing\RouterInterface $router)
    {/*{{{*/
        $this->container->add($router, self::KEY_ROUTER);
    }/*}}}*/

    /**
        * Get router instance
        *
        * @return \Vine\Component\Routing\RouterInterface
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
        * @return \Vine\Component\Controller\ControllerInterface
     */
    public function loadController($appName, $moduleName, $controllerName)
    {/*{{{*/
        $clsName = '\\'.ucfirst($appName).'\Controller\\';
        $clsName.= ucfirst($moduleName).'\\'.ucfirst($controllerName);

        if (!class_exists($clsName)) {
            throw new \Vine\Framework\Error\Exception(\Vine\Framework\Error\Errno::E_CONTROLLER_CONTROLLER_NOT_EXISTS);
        }

        $controller = new $clsName();
        if (!$controller instanceof \Vine\Component\Controller\ControllerInterface) {
            throw new \Vine\Framework\Error\Exception(\Vine\Framework\Error\Errno::E_COMMON_INVALID_INSTANCE,'controller must be an instance of \Vine\Component\Controller\ControllerInterface');
        }

        return $controller;
    }/*}}}*/
}/*}}}*/
