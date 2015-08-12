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
        * @param Rule\RuleInterface $rule
        * @param Route\RouteInterface $route
        *
        * @return this
     */
    public function addRoute(Rule\RuleInterface $rule, Route\RouteInterface $route);

    /**
        * Set default route
        *
        * @param Route\RouteInterface $route
        *
        * @return 
     */
    public function setDefaultRoute(Route\RouteInterface $route);

    /**
        * Route by request
        *
        * @param \Vine\Component\Http\RequestInterface $request
        *
        * @return Route\RouteInterface
     */
    public function route(\Vine\Component\Http\RequestInterface $request);
}/*}}}*/
