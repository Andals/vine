<?php
/**
* @file Mvc.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Routing\Route;

/**
    * Mvc or user defined
 */
class Mvc extends \Vine\Component\Routing\Route\Base
{/*{{{*/
    const DEF_CONTROLLER_NAME = 'index';
    const DEF_ACTION_NAME     = 'index';

    /**
        * {@inheritdoc}
     */
    public function go($appName, $moduleName, \Vine\Component\Loader\Base $loader)
    {/*{{{*/
        $request = $loader->loadRequest();
        $controllerNameActionName = $this->parseControllerNameActionName($request);
        $controllerName = $controllerNameActionName['controllerName'];
        $actionName     = $controllerNameActionName['actionName'];

        $controller = $this->loadController($appName, $moduleName, $controllerName, $actionName);
        $response   = $this->loadResponse($loader);
        $view       = $loader->loadView();

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


    private function parseControllerNameActionName($request)
    {/*{{{*/
        $controllerName = isset($this->userDefined['controllerName']) ? $this->userDefined['controllerName'] : '';
        $actionName     = isset($this->userDefined['actionName']) ? $this->userDefined['actionName'] : '';
        if ('' == $controllerName || '' == $actionName) {
            $uri     = trim($request->getUri(), '/');
            $uriData = ('' == $uri) ? array() : explode('/', $uri);

            if ('' == $controllerName) {
                $controllerName = isset($uriData[0]) ? $uriData[0] : self::DEF_CONTROLLER_NAME;
            }
            if ('' == $actionName) {
                $actionName = isset($uriData[1]) ? $uriData[1] : self::DEF_ACTION_NAME;
            }
        }
        return array(
            'controllerName' => lcfirst($controllerName),
            'actionName'     => lcfirst($actionName),
        );
    }/*}}}*/
    private function loadController($appName, $moduleName, $controllerName, $actionName)
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
    private function loadResponse($loader)
    {/*{{{*/
        $response = $loader->loadResponse();
        if (is_null($response)) {
            $response = new \Vine\Component\Http\Response();
            $loader->setResponse($response);
        }

        return $response;
    }/*}}}*/
}/*}}}*/
