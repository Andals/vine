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
    const KEY_VIEW = 'view';

    private $container = null;


    /**
        * Loader construct
        *
        * @param \Vine\Component\Container\ContainerInterface $container
        *
        * @return 
     */
    public function __construct(\Vine\Component\Container\ContainerInterface $container)
    {/*{{{*/
        $this->container = $container;
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
        $request = $this->container->get(self::KEY_REQUEST);
        if (is_null($request)) {
            $request = new \Vine\Component\Http\Request();
            $this->setRequest($request);
        }

        return $request;
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
        $response = $this->container->get(self::KEY_RESPONSE);
        if (is_null($response)) {
            $response = new \Vine\Component\Http\Response();
            $this->setResponse($response);
        }

        return $response;
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
        $router = $this->container->get(self::KEY_ROUTER);
        if (is_null($router)) {
            $router = new \Vine\Component\Routing\Router();
            $this->setRouter($router);
        }

        return $router;
    }/*}}}*/

    /**
        * Set view instance
        *
        * @param \Vine\Component\View\ViewInterface $request
        *
        * @return
     */
    public function setView(\Vine\Component\View\ViewInterface $view)
    {/*{{{*/
        $this->container->add($view, self::KEY_VIEW);
    }/*}}}*/
    
    /**
        * Get view instance
        *
        * @return \Vine\Component\View\ViewInterface
     */
    public function loadView()
    {/*{{{*/
        return $this->container->get(self::KEY_VIEW);
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
