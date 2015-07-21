<?php
/**
* @file Controller.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Controller;

/**
    * This is controller interface
 */
interface ControllerInterface
{/*{{{*/
    /**  
     * This method is invoked right before an action is to be executed 
     * You may override this method to do last-minute preparation for the action.
     * @param string $actionName the action to be executed.
     * @return boolean whether the action should be executed.
     */
    protected function beforeAction($actionName)
    {   
        return true;
    }   

    /** 
     * This method is invoked right after an action is executed.
     * You may override this method to do some postprocessing for the action.
     * @param string $actionName the action just executed.
     */
    protected function afterAction($actionName)
    {   
    }
    /**
     * set view object which is used to render template.
     * @param \Vine\Component\View\ViewInterface $view view object.
     */
    public function setView(\Vine\Component\View\ViewInterface $view)
    {
    }

    /**
     * render view automatically.
     * this function is tiggered when response is not set by user in the action function.
     * @param \Vine\Component\Http\ResponseInterface $response view object.
     */
    public function autoRender(\Vine\Component\Http\ResponseInterface $response)
    {
    }
}/*}}}*/
