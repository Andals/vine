<?php
/**
* @file Web.php
* @author ligang
* @version 1.0
* @date 2015-07-02
 */

namespace Vine\Framework\App;

/**
    * This is app for web which has view
 */
final class Web extends \Vine\Framework\App\Base
{/*{{{*/

    /**
        * {@inheritdoc}
     */
    public function run($moduleName)
    {/*{{{*/
        $request  = $this->loader->loadRequest();
        $route    = $this->loader->loadRouter()->findRoute($request);
        $response = $this->loader->loadResponse();
        $view     = $this->loader->loadView();

        $routingLoader = new \Vine\Component\Routing\Loader(new \Vine\Component\Container\Obj());
        $routingLoader->setRequest($request);
        $routingLoader->setResponse($response);
        if (!is_null($view)) {
            $routingLoader->setView($view);
        }

        $response = $route->go($this->appName, $moduleName, $routingLoader);
        if ($response instanceof \Vine\Component\Http\ResonseInterface) {
            $response->send();
        }
    }/*}}}*/
}/*}}}*/
