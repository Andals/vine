<?php
namespace Vine\Controller;

/**
    * This is controller base
 */
abstract class Base implements \Vine\Contract\Controller
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
    public function dispatch($actionName, \Vine\Contract\Request $request, \Vine\Contract\Response $response)
    {/*{{{*/
        $this->request  = $request;
        $this->response = $response;

        $this->preAction();

        $funcName = lcfirst($actionName).'Action';
        if (!method_exists($this, $funcName)) {
            throw new \Vine\Error\Exception(\Vine\Error\Errno::E_CONTROLLER_ACTION_NOT_EXISTS);
        }
        $this->$funcName();

        $this->postAction();
    }/*}}}*/
}/*}}}*/
