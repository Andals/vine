<?php
namespace Vine\Controller;

/**
    * This is controller base
 */
abstract class Base implements \Vine\Contract\Controller
{/*{{{*/
    protected function preAction($request)
    {/*{{{*/
    }/*}}}*/
    protected function postAction($request)
    {/*{{{*/
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function dispatch($actionName, \Vine\Contract\Request $request)
    {/*{{{*/
        $this->preAction($request);

        $funcName = lcfirst($actionName).'Action';
        if (!method_exists($this, $funcName)) {
            throw new \Vine\Error\Exception(\Vine\Error\Errno::E_CONTROLLER_ACTION_NOT_EXISTS);
        }
        $this->$funcName($request);

        $this->postAction($request);
    }/*}}}*/
}/*}}}*/
