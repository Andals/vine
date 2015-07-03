<?php
/**
* @file Mvc.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Routing;

/**
    * Mvc or user defined
 */
class Route implements \Vine\Contract\Route
{/*{{{*/
    private $controllerName = '';
    private $actionName     = '';
    private $userDefined    = null;

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
    public function setControllerName($controllerName)
    {/*{{{*/
        $this->controllerName = $controllerName;
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
    public function setActionName($actionName)
    {/*{{{*/
        $this->actionName = $actionName;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function getUserDefined()
    {/*{{{*/
        return $this->userDefined;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function setUserDefined($userDefined)
    {/*{{{*/
        $this->userDefined = $userDefined;
    }/*}}}*/
}/*}}}*/
