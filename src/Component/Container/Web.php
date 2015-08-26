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

    const KEY_ERROR_CONTROLLER_NAME = 'error_controller_name';
    const KEY_ERROR_ACTION_NAME     = 'error_action_name';

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

    /**
        * Set error controller name
        *
        * @param string $controllerName
        *
        * @return self
     */
    public function setErrorControllerName($controllerName)
    {/*{{{*/
        return $this->add(self::KEY_ERROR_CONTROLLER_NAME, $controllerName);
    }/*}}}*/

    /**
        * Get error controller name
        *
        * @return string
     */
    public function getErrorControllerName()
    {/*{{{*/
        return $this->get(self::KEY_ERROR_CONTROLLER_NAME);
    }/*}}}*/

    /**
        * Set error action name
        *
        * @param string $actionName
        *
        * @return self
     */
    public function setErrorActionName($actionName)
    {/*{{{*/
        return $this->add(self::KEY_ERROR_ACTION_NAME, $actionName);
    }/*}}}*/

    /**
        * Get error action name
        *
        * @return string
     */
    public function getErrorActionName()
    {/*{{{*/
        return $this->get(self::KEY_ERROR_ACTION_NAME);
    }/*}}}*/
}/*}}}*/
