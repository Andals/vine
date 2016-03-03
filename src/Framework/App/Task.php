<?php
/**
* @file Task.php
* @author ligang
 */

namespace Vine\Framework\App;

/**
    * This is webapp
 */
final class Task extends Base
{/*{{{*/
    const PARAM_ARG_SEP = '=';

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
        if (!$bootstrap instanceof \Vine\Framework\Bootstrap\Task) {
            throw new \Vine\Framework\Error\Exception(
                \Vine\Framework\Error\Errno::E_SYS_INVALID_INSTANCE,
                get_class($bootstrap).' must instanceof \Vine\Component\Bootstrap\Task'
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
        try {
            $this->handleTask($moduleName, $this->container->getTaskArgs());
        } catch (\Exception $e) {
            $this->handleError($moduleName, $e);
        }
    }/*}}}*/


    protected function getContainer()
    {/*{{{*/
        return new \Vine\Component\Container\Task();
    }/*}}}*/

    private function handleTask($moduleName, $args)
    {/*{{{*/
        array_shift($args);

        $controllerName = $this->parseNonParamArg($args, 'index');
        $actionName     = $this->parseNonParamArg($args, 'index');

        $params = array();
        foreach ($args as $arg) {
            $arg = trim($arg);
            if ($this->isParamArg($arg)) {
                $item = explode(self::PARAM_ARG_SEP, $arg);
                $params[$item[0]] = $item[1];
            }
        }
        $this->container->setTaskParams($params);

        $controller = $this->getController($this->appName, $moduleName, $controllerName, $actionName);
        $controller->setActionParams($params, new \Vine\Component\Validator\Validator());

        $this->runController($controller, $actionName);
    }/*}}}*/
    private function handleError($moduleName, $e)
    {/*{{{*/
        $controllerName = $this->container->getErrorControllerName();
        $actionName     = $this->container->getErrorActionName();

        $controller = $this->getController($this->appName, $moduleName, $controllerName, $actionName);

        $this->runController($controller, $actionName, array($e));
    }/*}}}*/

    private function initComponents()
    {/*{{{*/
        $this->container->setTaskArgs($_SERVER['argv'])
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
        call_user_func_array(array($controller, $actionFuncName), $actionArgs);
        $controller->afterAction();
    }/*}}}*/

    private function parseNonParamArg(&$args, $default)
    {/*{{{*/
        $value = $default;

        if (!empty($args)) {
            $arg = trim($args[0]);
            if (!$this->isParamArg($arg)) {
                $value = $arg;
                array_shift($args);
            }
        }

        return $value;
    }/*}}}*/
    private function isParamArg($arg)
    {/*{{{*/
        $pos = strpos($arg, self::PARAM_ARG_SEP);

        if ($pos == 0) {
            return false;
        }
        if ($pos == (strlen($arg) - 1)) {
            return false;
        }

        return true;
    }/*}}}*/
}/*}}}*/
