<?php
/**
* @file Base.php
* @brief controller base class
* @author haoyankai
* @version 1.0
* @date 2015-07-20
 */

namespace Vine\Component\Controller;

abstract class Base implements \Vine\Component\Controller\ControllerInterface
{
    /**  
     * @var string current module name.
     */
    private $moduleName;

    /**  
     * @var string current controller name.
     */
    private $controllerName;

    /**  
     * @var current action name.
     */
    private $actionName;

    /**  
     * @var \Vine\Component\View\ViewInterface the view used to render template.
     */
    protected $view;

    /**  
     * @var boolean whether render view or not.
     */
    protected $isViewRender;

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
        if (empty($moduleName)) {
            $moduleName = '';
        }
        $this->moduleName = $moduleName;
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
    }

    /**  
     * module name getter.
     * @return string module name.
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**  
     * controller name getter.
     * @return string controller name.
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**  
     * action name getter.
     * @return string action name.
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * {@inheritdoc}
     */
    public function setView(\Vine\Component\View\ViewInterface $view)
    {
        $this->view = $view;
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
     * set whether to render view or not.
     * true indicates the action will render view, false not.
     * @param boolean $isRender whether to render view or not.
     */
    public function setViewRender($isRender)
    {
        $this->isViewRender = $isRender;
    }

    /**
     * render data into template and return generated html.
     * @param string $tpl template name.
     * If empty string is given, the template with action name will be rendered.
     * @param boolean $withViewSuffix whether parameter $tpl with suffix or not.Default to be false.
     * EXAMPLE:If $tpl='index.php', $withViewSuffix should be true.
     *         If $tpl='index', $withViewSuffix should be false.
     * @param array $data data to render into template.
     * @return string|boolean generated html or false if $isViewRender set to false. 
     */
    public function render($tpl = '', $withViewSuffix = false, array $data = array())
    {
        if ($this->isViewRender === true) {
            $tplFolder = $this->moduleName . '/' . $this->controllerName . '/';
            if ($tpl != '') {
                $tplPath = $tplFolder . $tpl;
            } else {
                $tplPath = $tplFolder . $this->getActionName();
            }
            return $this->view->render($tplPath, $withViewSuffix, $data);
        }
        return false;
    }

    /**
     * render data into template and set generated html into response object.
     * @param string $tpl template name.
     * @param boolean $withViewSuffix.
     * @param array $data data to render into template.
     */
    public function display($tpl = '', $withViewSuffix = false, array $data = array())
    {
        $content = $this->render($tpl, $withViewSuffix, $data);
        if ($content !== false) {
            $this->response->setBody($content);
        }
    }

    /**  
     * {@inheritdoc}
     */
    public function autoRender()
    {
        $this->display();
    }

    /**  
     * {@inheritdoc}
     */
    public function beforeAction()
    {
        return true;
    }

    /**  
     * {@inheritdoc}
     */
    public function afterAction()
    {
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
     * redirect to destination url.
     * @see \Vine\Component\Http\Response::redirect() for detail information.
     * @param string $url redirect destination.
     */
    protected function redirect($url)
    {   
        $this->response->redirect($url);
    }

}
