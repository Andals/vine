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
        $request = $this->loadRequest();
        $route   = $this->loadRouter()->forward($request);

        $response = $route->go($this->appName, $moduleName, $this->loader);
        if ($response instanceof \Vine\Component\Http\ResponseInterface) {
            $response->send();
        }
    }/*}}}*/


    protected function getLoader()
    {/*{{{*/
        return new \Vine\Component\Loader\WebApp(new \Vine\Component\Container\Obj());
    }/*}}}*/


    private function loadRequest()
    {/*{{{*/
        $request = $this->loader->loadRequest();
        if (is_null($request)) {
            $request = new \Vine\Component\Http\Request();
            $this->loader->setRequest($request);
        }

        return $request;
    }/*}}}*/
    private function loadResponse()
    {/*{{{*/
        $response = $this->loader->loadResponse();
        if (is_null($response)) {
            $response = new \Vine\Component\Http\Response();
            $this->loader->setResponse($response);
        }

        return $response;
    }/*}}}*/
    private function loadRouter()
    {/*{{{*/
        $router = $this->loader->loadRouter();
        if (is_null($router)) {
            $router = new \Vine\Component\Routing\Router();
            $this->loader->setRouter($router);
        }

        return $router;
    }/*}}}*/
}/*}}}*/
