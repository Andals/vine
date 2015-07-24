<?php
namespace Vine\Component\View;

/**
 * This is view base
 */
abstract class Base implements \Vine\Component\View\ViewInterface
{/*{{{*/

    /**
     * view root
     * 
     * @var string
     */
    protected $viewRoot = '';
    
    /**
     * view file
     * @var string
     */
    protected $viewFile = '';
    
    /**
     * view suffix
     * @var string
     */
    protected $viewSuffix = '';

    /**
     * {@inheritdoc}
     */
	public function setViewRoot($viewRoot)
    {
        $this->viewRoot = rtrim($viewRoot, '/') . '/';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getViewRoot()
    {
        return $this->viewRoot;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setViewSuffix($viewSuffix)
    {
    	$this->viewSuffix = $viewSuffix;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getViewSuffix()
    {
        return $this->viewSuffix;
    }
    
    /**
     * get view file with view root
     * 
     * @param string $viewFile
     * @param bool $withViewSuffix
     * 
     * @throws \Exception
     * @return string
     */
    protected function getViewFileWithViewRoot($viewFile, $withViewSuffix)
    {
        $viewFile = $this->viewRoot . ltrim($viewFile, '/');
        if (! $withViewSuffix) {
            $viewFile .= $this->viewSuffix;
        }
        
        if (! file_exists($viewFile)) {
            throw new \Exception('view file ' . $viewFile . ' not exists');
        }
        return $viewFile;
    }
}
