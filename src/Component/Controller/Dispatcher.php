<?php
/**
* @file Dispatcher.php
* @author ligang
* @version 1.0
* @date 2015-07-28
 */

namespace Vine\Component\Controller;

/**
    * This is controller dispatcher
 */
class Dispatcher
{/*{{{*/
    public function dispatch($appName, $moduleName, $controllerName, $actionName, \Vine\Component\Container\Web $container)
    {/*{{{*/
        $controller = $this->getController($appName, $moduleName, $controllerName, $actionName);
        $request    = $container->getRequest();
        $response   = $container->getResponse();
        $view       = $container->getView();

        $controller->setRequest($request);
        $controller->setResponse($response);
        $controller->setView($view);

        if (!method_exists($controller, $actionName)) {
            throw new \Exception("Action $actionName not exists");
        }

        $controller->beforeAction();
        $controller->$actionName();
        $controller->afterAction();
        $controller->autoRender();

        return $response;
    }/*}}}*/


    private function getController($appName, $moduleName, $controllerName, $actionName)
    {/*{{{*/
        $clsName = '\\'.ucfirst($appName).'\Controller\\';
        $clsName.= ucfirst($moduleName).'\\'.ucfirst($controllerName);
        if (!class_exists($clsName)) {
            throw new \Exception("Controller $clsName not exists");
        }

        $controller = new $clsName($moduleName, $controllerName, $actionName);
        if (!$controller instanceof \Vine\Component\Controller\ControllerInterface) {
            throw new \Exception($clsName.' must be an instance of \Vine\Component\Controller\ControllerInterface');
        }

        return $controller;
    }/*}}}*/
}/*}}}*/
