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
final class Web extends Base
{/*{{{*/

    /**
        * {@inheritdoc}
     */
    public function bootStrap($bootstrap)
    {/*{{{*/
        if (!$bootstrap instanceof \Vine\Component\Bootstrap\Web) {
            throw new \Vine\Framework\Error\Exception(
                \Vine\Framework\Error\Errno::E_COMMON_INVALID_INSTANCE,
                get_class($bootstrap).' must instanceof \Vine\Component\Bootstrap\Web'
            );
        }

        $bootstrap->boot($this->container);

        return $this;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function run($moduleName)
    {/*{{{*/
        $this->initComponents();

        $request = $this->container->getRequest();
        $route   = $this->container->getRouter()->forward($request);

        $response = $route->go($this->appName, $moduleName, $this->container);
        if ($response instanceof \Vine\Component\Http\ResponseInterface) {
            $response->send();
        }
    }/*}}}*/


    protected function getContainer()
    {/*{{{*/
        return new \Vine\Component\Container\Web();
    }/*}}}*/


    private function initComponents()
    {/*{{{*/
        $this->initRequest();
        $this->initRouter();
        $this->initResponse();
    }/*}}}*/
    private function initRequest()
    {/*{{{*/
        if (!$this->container->have(\Vine\Component\Container\Web::KEY_REQUEST)) {
            $request = new \Vine\Component\Http\Request();
            $this->container->setRequest($request);
        }
    }/*}}}*/
    private function initRouter()
    {/*{{{*/
        if (!$this->container->have(\Vine\Component\Container\Web::KEY_ROUTER)) {
            $router = new \Vine\Component\Routing\Router();
            $this->container->setRouter($router);
        }
    }/*}}}*/
    private function initResponse()
    {/*{{{*/
        if (!$this->container->have(\Vine\Component\Container\Web::KEY_RESPONSE)) {
            $response = new \Vine\Component\Http\Response();
            $this->container->setResponse($response);
        }
    }/*}}}*/
}/*}}}*/
