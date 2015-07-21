<?php
/**
* @file Router.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Routing;

/**
    * This is default router
 */
class Router implements \Vine\Component\Routing\RouterInterface
{/*{{{*/
    private $routeTable   = array();
    private $defaultRoute = null;

    /**
        * {@inheritdoc}
     */
    public function addRule(\Vine\Component\Routing\Rule\RuleInterface $rule, \Vine\Component\Routing\Route\RouteInterface $route)
    {/*{{{*/
        $this->routeTable[] = array(
            'rule'  => $rule,
            'route' => $route,
        );
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function setDefaultRoute(\Vine\Component\Routing\Rout\RouteInterface $route)
    {/*{{{*/
        $this->defaultRoute = $route;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function findRoute(\Vine\Component\Http\RequestInterface $request)
    {/*{{{*/
        foreach ($this->routeTable as $routeItem) {
            $rule = $routeItem['rule'];
            if ($rule->match($request)) {
                return $routeItem['route'];
            }
        }

        return is_null($this->defaultRoute) ? new \Vine\Component\Routing\Route\Mvc() : $this->defaultRoute;
    }/*}}}*/
}/*}}}*/
