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
        * @param \Vine\Component\Routing\Route\RouteInterface $route
        * @param mixed $userDefined
        *
        * @return 
     */
    public function addRule(\Vine\Component\Routing\Rule\RuleInterface $rule, \Vine\Component\Routing\Route\RouteInterface $route);

    /**
        * Set default route
        *
        * @param \Vine\Component\Routing\Route\RouteInterface $route
        * @param mixed $userDefined
        *
        * @return 
     */
    public function setDefaultRoute(\Vine\Component\Routing\Rout\RouteInterface $route);

    /**
        * Find route by request
        *
        * @param \Vine\Component\Http\RequestInterface $request
        *
        * @return \Vine\Component\Routing\Route\RouteInterface
     */
    public function findRoute(\Vine\Component\Http\RequestInterface $request);
}/*}}}*/
