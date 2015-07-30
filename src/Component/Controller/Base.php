<?php
/**
* @file Base.php
* @brief controller base class
* @author haoyankai
* @version 1.0
* @date 2015-07-20
 */

namespace Vine\Component\Controller;

abstract class Base implements ControllerInterface
{
    /**  
     * @var string current module name.
     */
    protected $moduleName;

    /**  
     * @var string current controller name.
     */
    protected $controllerName;

    /**  
     * @var current action name.
     */
    protected $actionName;

    /**  
     * @var \Vine\Component\View\ViewInterface the view used to render template.
     */
    protected $view;

    /**  
     * @var boolean whether render view or not.
     */
    protected $needViewRender;

    /**  
     * @var \Vine\Component\Http\RequestInterface request object.
     */
    protected $request;

    /**  
     * @var \Vine\Component\Http\ResponseInterface response object.
     */
    protected $response;

    /**  
     * {@inheritdoc}
     */
    public function __construct($moduleName, $controllerName, $actionName)
    {
        $this->moduleName     = lcfirst($moduleName);
        $this->controllerName = $controllerName;
        $this->actionName     = $actionName;
        $this->needViewRender = false;
    }

    /**
     * {@inheritdoc}
     */
    public function setView(\Vine\Component\View\ViewInterface $view = null)
    {
        $this->view = $view;

        $this->needViewRender = is_null($view) ? false : true;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequest(\Vine\Component\Http\RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse(\Vine\Component\Http\ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**  
     * {@inheritdoc}
     */
    public function beforeAction()
    {
    }

    /**  
     * {@inheritdoc}
     */
    public function afterAction()
    {
    }

    /**  
     * {@inheritdoc}
     */
    public function autoRender()
    {
        $tpl = $this->moduleName . '/' . $this->controllerName . '/' . $this->actionName;

        $this->display($tpl);
    }


    /**
     * assign data into template.
     * @see \Vine\Component\View\ViewInterface::assign() for detail information.
     * @param string $key data key.
     * @param mixed $value data value.
     * @param bool $secureFilter whether to filter data or not, for security issues.
     */
    protected function assign($key, $value, $secureFilter = true)
    {
        $this->view->assign($key, $value, $secureFilter);
    }

    /**
     * render data into template and set generated html into response object.
     * @param string $tpl template name.
     * @param boolean $withViewSuffix.
     * @param array $data data to render into template.
     */
    protected function display($tpl, $withViewSuffix = false)
    {
        $content = $this->view->render($tpl, $withViewSuffix);
        if ($content !== false) {
            $this->response->setBody($content);
        }
    }
}
