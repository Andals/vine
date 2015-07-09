<?php

namespace Vine\View;

class Smarty extends Base
{

    /**
     * Smarty object
     *
     * @var Smarty
     */
    protected $Smarty;

    /**
     * construct method
     *
     * @param string $compileDir
     * @param string $cacheDir
     * @param string $caching
     * @param string $leftDelimiter
     * @param string $rightDelimiter
     */
    public function __construct($compileDir, $cacheDir = "./", $caching = false, $leftDelimiter = "{%", $rightDelimiter = "%}")
    {
        // init Smarty
        $this->Smarty = new \Smarty();
        $this->Smarty->caching = $caching;
        
        $this->Smarty->template_dir = $this->viewPath;
        $this->Smarty->compile_dir = $compileDir;
        $this->Smarty->cache_dir = $cacheDir;
        
        $this->Smarty->left_delimiter = $leftDelimiter;
        $this->Smarty->right_delimiter = $rightDelimiter;
    }

    
    /**
     * {@inheritdoc}
     */
    public function assign($key, $value, $secureFilter=true)
    {
        $this->Smarty->assign($key, $value, $secureFilter);
    }
    
    /**
     * {@inheritdoc}
     */
    public function render($tplName, $data=array())
    {
        $tplFile = $this->getTplFile($tplName);
        return $this->Smarty->fetch($tplFile);
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function display($tplName, $data=array())
    {
        $tpl = $this->render($tplName, $data);
        echo($tpl);
    }
}