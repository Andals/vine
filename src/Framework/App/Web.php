<?php
/**
* @file Web.php
* @author ligang
* @version 1.0
* @date 2015-07-02
 */

namespace Vine\Framework\App;

/**
    * This is webapp
 */
final class Web extends Base
{/*{{{*/
    public function __construct($appName)
    {/*{{{*/
        parent::__construct($appName);

        $this->initComponents();
    }/*}}}*/

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
        $request = $this->container->getRequest();
        $route   = $this->container->getRouter()->route($request);

        $actionName = $route->getActionName();
        $controller = $this->getController($this->appName, $moduleName, $route->getControllerName(), $actionName);
        $controller->setRequest($request)->setView($this->container->getView());

        $response = call_user_func_array(array($controller, $actionName), $route->getActionArgs());

        if (!$response instanceof \Vine\Component\Http\ResponseInterface) {
            throw new \Vine\Framework\Error\Exception(
                \Vine\Framework\Error\Errno::E_COMMON_INVALID_INSTANCE,
                'resonse must instanceof \Vine\Component\Http\ResponseInterface'
            );
        }

        $response->send();
    }/*}}}*/


    protected function getContainer()
    {/*{{{*/
        return new \Vine\Component\Container\Web();
    }/*}}}*/


    private function initComponents()
    {/*{{{*/
        $this->initRequest();
        $this->initRouter();
    }/*}}}*/
    private function initRequest()
    {/*{{{*/
        $factory = new \Vine\Component\Http\RequestFactory();

        $this->container->setRequest($factory->make());
    }/*}}}*/
    private function initRouter()
    {/*{{{*/
        $this->container->setRouter(new \Vine\Component\Routing\Router());
    }/*}}}*/
    
    private function getController($appName, $moduleName, $controllerName, $actionName)
    {/*{{{*/
        $clsName = '\\'.ucfirst($appName).'\Controller\\';
        $clsName.= ucfirst($moduleName).'\\'.ucfirst($controllerName);
        if (!class_exists($clsName)) {
            throw new \Exception("Controller $clsName not exists");
        }

        $controller = new $clsName($moduleName, $controllerName, $actionName);
        if (!$controller instanceof \Vine\Component\Controller\Base) {
            throw new \Exception($clsName.' must be an instance of \Vine\Component\Controller\Base');
        }
        if (!method_exists($controller, $actionName)) {
            throw new \Exception("Action $actionName not exists");
        }

        return $controller;
    }/*}}}*/
}/*}}}*/
