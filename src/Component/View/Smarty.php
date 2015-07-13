<?php

namespace Vine\Component\View;

class Smarty extends Base
{

    /**
     * Smarty object
     *
     * @var \Smarty
     */
    protected $smarty;

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
        $this->smarty = new \Smarty();
        $this->smarty->caching = $caching;
        
        $this->smarty->template_dir = $this->viewRoot;
        $this->smarty->compile_dir = $compileDir;
        $this->smarty->cache_dir = $cacheDir;
        
        $this->smarty->left_delimiter = $leftDelimiter;
        $this->smarty->right_delimiter = $rightDelimiter;
    }

    
    /**
     * {@inheritdoc}
     */
    public function assign($key, $value, $secureFilter=true)
    {
        $this->smarty->assign($key, $value, $secureFilter);
    }
    
    /**
     * {@inheritdoc}
     */
    public function render($tplName, $data=array())
    {
        $tplFile = $this->getTplFile($tplName);
        return $this->smarty->fetch($tplFile);
    }
}