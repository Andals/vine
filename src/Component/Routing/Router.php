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
class Router implements RouterInterface
{/*{{{*/
    private $routeTable   = array();
    private $defaultRoute = null;

    /**
        * {@inheritdoc}
     */
    public function addRoute(Rule\RuleInterface $rule, Route\RouteInterface $route)
    {/*{{{*/
        $this->routeTable[] = array(
            'rule'  => $rule,
            'route' => $route,
        );

        return $this;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function setDefaultRoute(Route\RouteInterface $route)
    {/*{{{*/
        $this->defaultRoute = $route;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function route(\Vine\Component\Http\RequestInterface $request)
    {/*{{{*/
        $actionArgs = array();
        foreach ($this->routeTable as $item) {
            if ($item['rule']->match($request, $actionArgs)) {
                return $item['route']->setActionArgs($actionArgs);
            }
        }

        if (!is_null($this->defaultRoute)) {
            return $this->defaultRoute;
        }

        $route    = new Route\General();
        $path     = trim($request->getUrlPath(), '/');
        $pathData = ($path == '') ? array() : explode('/', $path);

        if (isset($pathData[0])) {
            $route->setControllerName($pathData[0]);
        }
        if (isset($pathData[1])) {
            $route->setActionName($pathData[1]);
        }

        return $route;
    }/*}}}*/
}/*}}}*/
