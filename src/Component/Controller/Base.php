<?php
namespace Vine\Component\Controller;

/**
    * This is controller base
 */
abstract class Base implements \Vine\Component\Controller\ControllerInterface
{/*{{{*/
    protected $request = null;
    protected $response = null;

    protected function preAction()
    {/*{{{*/
    }/*}}}*/
    protected function postAction()
    {/*{{{*/
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function dispatch($actionName, \Vine\Component\Http\RequestInterface $request, \Vine\Component\Http\ResponseInterface $response)
    {/*{{{*/
        $this->request  = $request;
        $this->response = $response;

        $this->preAction();

        $funcName = lcfirst($actionName).'Action';
        if (method_exists($this, $funcName)) {
            $this->$funcName();
        }

        $this->postAction();
    }/*}}}*/
}/*}}}*/
