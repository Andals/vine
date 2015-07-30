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
class Mvc extends Base
{/*{{{*/
    const DEF_CONTROLLER_NAME = 'index';
    const DEF_ACTION_NAME     = 'index';

    /**
        * {@inheritdoc}
     */
    public function go($appName, $moduleName, $container)
    {/*{{{*/
        if (!$container instanceof \Vine\Component\Container\Web) {
            throw new \Exception($container.' must instanceof \Vine\Component\Container\Web');
        }

        $request = $container->getRequest();

        $controllerNameActionName = $this->parseControllerNameActionName($request);
        $controllerName = $controllerNameActionName['controllerName'];
        $actionName     = $controllerNameActionName['actionName'];

        $dispatcher = new \Vine\Component\Controller\Dispatcher();
        $response   = $dispatcher->dispatch($appName, $moduleName, $controllerName, $actionName, $container);

        return $response;
    }/*}}}*/


    private function parseControllerNameActionName($request)
    {/*{{{*/
        $controllerName = isset($this->userDefined['controllerName']) ? $this->userDefined['controllerName'] : '';
        $actionName     = isset($this->userDefined['actionName']) ? $this->userDefined['actionName'] : '';
        if ($controllerName == '' || $actionName == '') {
            $uri     = trim($request->getUri(), '/');
            $uriData = ($uri == '') ? array() : explode('/', $uri);

            if ($controllerName == '') {
                $controllerName = isset($uriData[0]) ? $uriData[0] : self::DEF_CONTROLLER_NAME;
            }
            if ($actionName == '') {
                $actionName = isset($uriData[1]) ? $uriData[1] : self::DEF_ACTION_NAME;
            }
        }
        return array(
            'controllerName' => lcfirst($controllerName),
            'actionName'     => lcfirst($actionName),
        );
    }/*}}}*/
}/*}}}*/
