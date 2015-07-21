<?php
/**
* @file WebApp.php
* @author ligang
* @version 1.0
* @date 2015-07-24
 */

namespace Vine\Component\Loader;

class WebApp extends \Vine\Component\Loader\Base
{/*{{{*/
    const KEY_REQUEST  = 'request';
    const KEY_ROUTER   = 'router';
    const KEY_RESPONSE = 'response';
    const KEY_VIEW     = 'view';

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
}/*}}}*/
