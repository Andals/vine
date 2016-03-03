<?php
/**
* @file Base.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Framework\App;

/**
    * This is app base
 */
abstract class Base
{/*{{{*/
    protected $appName   = '';
    protected $container = null;

    /**
        * Run bootstrap
        *
        * @param mixed $bootstrap
        *
        * @return self
     */
    abstract public function bootstrap($bootstrap);

    /**
        * Run app process
        *
        * @param string $moduleName
        *
        * @return 
     */
    abstract public function run($moduleName);

    /**
        * Get app container
        *
        * @return \Vine\Component\Container\Base
     */
    abstract protected function getContainer();


    public function __construct($appName)
    {/*{{{*/
        $this->appName   = $appName;
        $this->container = $this->getContainer();
    }/*}}}*/


    protected function getController($appName, $moduleName, $controllerName, $actionName)
    {/*{{{*/
        $clsName = '\\'.ucfirst($appName).'\Controller\\';
        $clsName.= ucfirst($moduleName).'\\'.ucfirst($controllerName).'Controller';
        if (!class_exists($clsName)) {
            throw new \Vine\Framework\Error\Exception(\Vine\Framework\Error\Errno::E_SYS_CONTROLLER_NOT_EXISTS, "Controller $clsName not exists");
        }

        $controller = new $clsName($moduleName, $controllerName, $actionName);
        if (!$controller instanceof \Vine\Component\Controller\BaseController) {
            throw new \Vine\Framework\Error\Exception(\Vine\Framework\Error\Errno::E_SYS_INVALID_INSTANCE, $clsName.' must be an instance of \Vine\Component\Controller\BaseController');
        }

        return $controller;
    }/*}}}*/
}/*}}}*/
