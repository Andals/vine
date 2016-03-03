<?php
/**
* @file Obj.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Component\Container;

/**
    * Store mixed value use key => value
 */
class General extends Base
{/*{{{*/
    const KEY_ERROR_CONTROLLER_NAME = 'error_controller_name';
    const KEY_ERROR_ACTION_NAME     = 'error_action_name';

    /**
        * Set error controller name
        *
        * @param string $controllerName
        *
        * @return self
     */
    public function setErrorControllerName($controllerName)
    {/*{{{*/
        return $this->add(self::KEY_ERROR_CONTROLLER_NAME, $controllerName);
    }/*}}}*/

    /**
        * Get error controller name
        *
        * @return string
     */
    public function getErrorControllerName()
    {/*{{{*/
        return $this->get(self::KEY_ERROR_CONTROLLER_NAME);
    }/*}}}*/

    /**
        * Set error action name
        *
        * @param string $actionName
        *
        * @return self
     */
    public function setErrorActionName($actionName)
    {/*{{{*/
        return $this->add(self::KEY_ERROR_ACTION_NAME, $actionName);
    }/*}}}*/

    /**
        * Get error action name
        *
        * @return string
     */
    public function getErrorActionName()
    {/*{{{*/
        return $this->get(self::KEY_ERROR_ACTION_NAME);
    }/*}}}*/
}/*}}}*/
