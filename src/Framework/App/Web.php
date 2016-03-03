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
    public function bootstrap($bootstrap)
    {/*{{{*/
        if (!$bootstrap instanceof \Vine\Framework\Bootstrap\Web) {
            throw new \Vine\Framework\Error\Exception(
                \Vine\Framework\Error\Errno::E_SYS_INVALID_INSTANCE,
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

        try {
            $response = $this->handleRequest($moduleName, $request);
        } catch (\Exception $e) {
            $response = $this->handleError($moduleName, $request, $e);
        }

        $response->send();
    }/*}}}*/


    protected function getContainer()
    {/*{{{*/
        return new \Vine\Component\Container\Web();
    }/*}}}*/

    private function handleRequest($moduleName, $request)
    {/*{{{*/
        $route = $this->container->getRouter()->route($request);

        $controllerName = $route->getControllerName();
        $actionName     = $route->getActionName();

        $controller = $this->getController($this->appName, $moduleName, $controllerName, $actionName);
        $controller->setRequest($request, new \Vine\Component\Validator\Validator())
                   ->setView($this->container->getView());

        return $this->runController($controller, $actionName, $route->getActionArgs());
    }/*}}}*/
    private function handleError($moduleName, $request, $e)
    {/*{{{*/
        $controllerName = $this->container->getErrorControllerName();
        $actionName     = $this->container->getErrorActionName();

        $controller = $this->getController($this->appName, $moduleName, $controllerName, $actionName);
        $controller->setRequest($request)
                   ->setView($this->container->getView());

        return $this->runController($controller, $actionName, array($e));
    }/*}}}*/

    private function initComponents()
    {/*{{{*/
        $factory = new \Vine\Component\Http\RequestFactory();
        $request = $factory->make();
        $router  = new \Vine\Component\Routing\Router();

        $this->container->setRequest($request)
                        ->setRouter($router)
                        ->setErrorControllerName('error')
                        ->setErrorActionName('index');
    }/*}}}*/
    
    private function runController($controller, $actionName, $actionArgs = array())
    {/*{{{*/
        $actionFuncName = lcfirst($actionName).'Action';
        if (!method_exists($controller, $actionFuncName)) {
            throw new \Vine\Framework\Error\Exception(\Vine\Framework\Error\Errno::E_SYS_ACTION_NOT_EXISTS, "Action $actionName not exists");
        }

        $controller->beforeAction();
        $response = call_user_func_array(array($controller, $actionFuncName), $actionArgs);
        $controller->afterAction();

        if (!$response instanceof \Vine\Component\Http\ResponseInterface) {
            throw new \Vine\Framework\Error\Exception(
                \Vine\Framework\Error\Errno::E_SYS_INVALID_INSTANCE,
                'response must instanceof \Vine\Component\Http\ResponseInterface'
            );
        }

        return $response;
    }/*}}}*/
}/*}}}*/
