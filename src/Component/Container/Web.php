<?php
/**
* @file Web.php
* @author ligang
* @version 1.0
* @date 2015-07-28
 */

namespace Vine\Component\Container;

/**
    * Web container
 */
class Web extends Obj
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
        $this->add($request, self::KEY_REQUEST);
    }/*}}}*/

    /**
        * Get request instance
        *
        * @return \Vine\Component\Http\RequestInterface
     */
    public function getRequest()
    {/*{{{*/
        return $this->get(self::KEY_REQUEST);
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
        $this->add($response, self::KEY_RESPONSE);
    }/*}}}*/

    /**
        * Get response instance
        *
        * @return \Vine\Component\Http\ResponseInterface
     */
    public function getResponse()
    {/*{{{*/
        return $this->get(self::KEY_RESPONSE);
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
        $this->add($router, self::KEY_ROUTER);
    }/*}}}*/

    /**
        * Get router instance
        *
        * @return \Vine\Component\Routing\RouterInterface
     */
    public function getRouter()
    {/*{{{*/
        return $this->get(self::KEY_ROUTER);
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
        $this->add($view, self::KEY_VIEW);
    }/*}}}*/
    
    /**
        * Get view instance
        *
        * @return \Vine\Component\View\ViewInterface
     */
    public function getView()
    {/*{{{*/
        return $this->get(self::KEY_VIEW);
    }/*}}}*/
}/*}}}*/
