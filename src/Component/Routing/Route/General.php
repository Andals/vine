<?php
/**
* @file General.php
* @author ligang
* @version 1.0
* @date 2015-08-12
 */

namespace Vine\Component\Routing\Route;

/**
    * General route
 */
class General implements RouteInterface
{/*{{{*/
    private $controllerName = 'index';
    private $actionName     = 'index';
    private $actionArgs     = array();

    /**
        * {@inheritdoc}
     */
    public function setControllerName($controllerName)
    {/*{{{*/
        $this->controllerName = $controllerName;

        return $this;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function getControllerName()
    {/*{{{*/
        return $this->controllerName;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function setActionName($actionName)
    {/*{{{*/
        $this->actionName = $actionName;

        return $this;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function getActionName()
    {/*{{{*/
        return $this->actionName;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function setActionArgs($args = array())
    {/*{{{*/
        $this->actionArgs = $args;

        return $this;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function getActionArgs()
    {/*{{{*/
        return $this->actionArgs;
    }/*}}}*/
}/*}}}*/
