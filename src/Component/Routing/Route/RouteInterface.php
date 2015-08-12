<?php
/**
* @file Route.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Routing\Route;

/**
    * This is route interface
 */
interface RouteInterface
{/*{{{*/

    /**
        * Set controllerName
        *
        * @param string $controllerName
        *
        * @return this
     */
    public function setControllerName($controllerName);

    /**
        * Get controllerName
        *
        * @return string
     */
    public function getControllerName();

    /**
        * Set actionName
        *
        * @param string $actionName
        *
        * @return this
     */
    public function setActionName($actionName);

    /**
        * Get actionName
        *
        * @return string
     */
    public function getActionName();

    /**
        * Set action func args
        *
        * @param array $args
        *
        * @return this
     */
    public function setActionArgs($args = array());

    /**
        * Get action func args
        *
        * @return array
     */
    public function getActionArgs();
}/*}}}*/
