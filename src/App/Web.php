<?php
/**
* @file Web.php
* @author ligang
* @version 1.0
* @date 2015-07-02
 */

namespace Vine\App;

/**
    * This is app for web which has view
 */
final class Web extends \Vine\App\Base
{/*{{{*/

    /**
        * {@inheritdoc}
     */
    public function run($moduleName)
    {/*{{{*/
        $request  = $this->loader->loadRequest();
        $route    = $this->loader->loadRouter()->findRoute($request);
        $response = $this->loader->loadResponse();

        $userDefined = $route->getUserDefined();
        if (is_callable($userDefined)) {
            call_user_func($userDefined, $request, $response);
        } else {
            $controller = $this->loader->loadController($this->appName, $moduleName, $route->getControllerName());
            $controller->dispatch($route->getActionName(), $request, $response);
        }
    }/*}}}*/
}/*}}}*/
