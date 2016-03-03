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
class Web extends General
{/*{{{*/
    const KEY_REQUEST = 'request';
    const KEY_ROUTER  = 'router';
    const KEY_VIEW    = 'view';

    /**
        * Set request instance
        *
        * @param \Vine\Component\Http\RequestInterface $request
        *
        * @return self
     */
    public function setRequest(\Vine\Component\Http\RequestInterface $request)
    {/*{{{*/
        return $this->add(self::KEY_REQUEST, $request);
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
        * Set router instance
        *
        * @param \Vine\Component\Routing\RouterInterface $router
        *
        * @return self
     */
    public function setRouter(\Vine\Component\Routing\RouterInterface $router)
    {/*{{{*/
        return $this->add(self::KEY_ROUTER, $router);
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
        * @return self
     */
    public function setView(\Vine\Component\View\ViewInterface $view)
    {/*{{{*/
        return $this->add(self::KEY_VIEW, $view);
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
