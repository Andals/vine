<?php
/**
* @file Route.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Routing;

/**
    * This is route interface
 */
interface RouteInterface
{/*{{{*/

    /**
        * Get controller name
        *
        * @return string
     */
    public function getControllerName();

    /**
        * Set controller name
        *
        * @param string $controllerName
        *
        * @return 
     */
    public function setControllerName($controllerName);

    /**
        * Get action name
        *
        * @return string
     */
    public function getActionName();

    /**
        * Set action name
        *
        * @param string $actionName
        *
        * @return 
     */
    public function setActionName($actionName);

    /**
        * Get user defined function
        *
        * @return callable
     */
    public function getUserDefined();

    /**
        * Set user defined function
        *
        * @param callable $userDefined
        *
        * @return 
     */
    public function setUserDefined($userDefined);
}/*}}}*/
