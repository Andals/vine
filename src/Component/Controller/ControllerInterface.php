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
     * Constructor.
     * moduleName, controllerName, actionName is set in this method.
     * @param string $moduleName module name.
     * @param string $controllerName controller name.
     * @param string $actionName action name.
     */
    public function __construct($moduleName, $controllerName, $actionName);

    /**
     * set view object which is used to render template.
     * @param \Vine\Component\View\ViewInterface $view view object.
     */
    public function setView(\Vine\Component\View\ViewInterface $view=null);

    /**
     * set request object.
     * NOTE:Request object is needed in action methods.
     * We should guarantee this method is called before that.
     * @param \Vine\Component\Http\RequestInterface $request request object.
     */
    public function setRequest(\Vine\Component\Http\RequestInterface $request);

    /**
     * set response object.
     * NOTE:Response object is needed in action methods.
     * We should guarantee this method is called before that.
     * @param \Vine\Component\Http\ResponseInterface $response response object.
     */
    public function setResponse(\Vine\Component\Http\ResponseInterface $response);

    /**  
     * This method is invoked right before an action is to be executed 
     * You may override this method to do last-minute preparation for the action.
     * @return boolean whether the action should be executed.
     */
    public function beforeAction();

    /** 
     * This method is invoked right after an action is executed.
     * You may override this method to do some postprocessing for the action.
     */
    public function afterAction();

    /**
     * render view automatically.
     * this method is invoked when response is not set in the action function.
     */
    public function autoRender();
}/*}}}*/
