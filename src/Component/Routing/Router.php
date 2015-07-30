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
    private $defaultRoute = array();

    public function __construct()
    {/*{{{*/
        $this->defaultRoute = array(
            'routeClsName'  => '\Vine\Component\Routing\Route\Mvc',
            'userDefined'   => array(),
        );
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function addRoute(\Vine\Component\Routing\Rule\RuleInterface $rule, $routeClsName, $userDefined = null)
    {/*{{{*/
        $this->routeTable[] = array(
            'rule'          => $rule,
            'routeClsName'  => $routeClsName,
            'userDefined'   => $userDefined,
        );
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function setDefaultRoute($routeClsName, $userDefined = null)
    {/*{{{*/
        $this->defaultRoute = array(
            'routeClsName'  => $routeClsName,
            'userDefined'   => $userDefined,
        );
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function forward(\Vine\Component\Http\RequestInterface $request)
    {/*{{{*/
        foreach ($this->routeTable as $routeItem) {
            $rule = $routeItem['rule'];
            if ($rule->match($request)) {
                return $this->loadRoute($routeItem['routeClsName'], $routeItem['userDefined']);
            }
        }

        return $this->loadRoute($this->defaultRoute['routeClsName'], $this->defaultRoute['userDefined']);
    }/*}}}*/


    private function loadRoute($routeClsName, $userDefined)
    {/*{{{*/
        $route = new $routeClsName();
        $route->setUserDefined($userDefined);

        return $route;
    }/*}}}*/
}/*}}}*/
