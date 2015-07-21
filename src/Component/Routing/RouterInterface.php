<?php
/**
* @file Router.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Routing;

/**
    * This is router interface
 */
interface RouterInterface
{/*{{{*/

    /**
        * Add rule to route table
        *
        * @param \Vine\Component\Routing\Rule\RuleInterface $rule
        * @param string $routeClsName
        * @param mixed $userDefined
        *
        * @return 
     */
    public function addRoute(\Vine\Component\Routing\Rule\RuleInterface $rule, $routeClsName, $userDefined=null);

    /**
        * Set default route
        *
        * @param string $routeClsName
        * @param mixed $userDefined
        *
        * @return 
     */
    public function setDefaultRoute($routeClsName, $userDefined=null);

    /**
        * Find route by request
        *
        * @param \Vine\Component\Http\RequestInterface $request
        *
        * @return \Vine\Component\Routing\Route\RouteInterface
     */
    public function forward(\Vine\Component\Http\RequestInterface $request);
}/*}}}*/
