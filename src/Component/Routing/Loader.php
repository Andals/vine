<?php
/**
* @file Loader.php
* @author ligang
* @version 1.0
* @date 2015-07-21
 */

namespace Vine\Component\Routing;

/**
    * Routing DI
 */
class Loader
{/*{{{*/
    const KEY_REQUEST  = 'request';
    const KEY_RESPONSE = 'response';
    const KEY_VIEW     = 'view';

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
