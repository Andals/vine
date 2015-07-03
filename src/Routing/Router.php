<?php
/**
* @file Router.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Routing;

/**
    * This is default router
 */
class Router implements \Vine\Contract\Router
{/*{{{*/
    const DEF_CONTROLLER_NAME = 'index';
    const DEF_ACTION_NAME     = 'index';

    /**
        * {@inheritdoc}
     */
    public function findRoute(\Vine\Contract\Request $request)
    {/*{{{*/
        $route = new \Vine\Routing\Route();

        $route->setControllerName(self::DEF_CONTROLLER_NAME);
        $route->setActionName(self::DEF_ACTION_NAME);

        return $route;
    }/*}}}*/
}/*}}}*/
