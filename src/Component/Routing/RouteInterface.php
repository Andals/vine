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
        * After router find a route, go for it.
        *
        * @param string $appName
        * @param string $moduleName
        * @param \Vine\Component\Http\Request $moduleName
        * @param array $ext
        *
        * @return \Vine\Component\Http\ResonseInterface
     */
    public function go($appName, $moduleName, $request, $ext=array());
}/*}}}*/
