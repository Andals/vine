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
     * get view file with view root
     * 
     * @param string $viewFile
     * 
     * @throws \Exception
     * @return string
     */
    protected function getViewFileWithViewRoot($viewFile)
    {
        $viewFile = $this->viewRoot . ltrim($viewFile, '/');
        if (! file_exists($viewFile)) {
            throw new \Exception('view file ' . $viewFile . ' not exists');
        }
        return $viewFile;
    }
}
