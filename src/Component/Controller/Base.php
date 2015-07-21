<?php
namespace Vine\Component\Controller;

/**
    * This is controller base
 */
abstract class Base implements \Vine\Component\Controller\ControllerInterface
{/*{{{*/
    protected $request = null;
    protected $response = null;

    public function __construct($moduleName, $controllerName, $actionName)
    {/*{{{*/
    }/*}}}*/
    public function setView(\Vine\Component\View\ViewInterface $view)
    {/*{{{*/
    }/*}}}*/
    public function setRequest(\Vine\Component\Http\RequestInterface $request)
    {/*{{{*/
        $this->request = $request;
    }/*}}}*/
    public function setResponse(\Vine\Component\Http\ResponseInterface $response)
    {/*{{{*/
        $this->response = $response;
    }/*}}}*/
    public function autoRender()
    {/*{{{*/
    }/*}}}*/
    public function beforeAction()
    {/*{{{*/
    }/*}}}*/
    public function afterAction()
    {/*{{{*/
    }/*}}}*/
}/*}}}*/
