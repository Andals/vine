<?php

namespace Vine\Component\View;

/**
 * This is view interface
 */
interface ViewInterface
{

    /**
     * Set view root, eg: $prjHome/src/view
     *
     * @param string $viewRoot
     */
    public function setViewRoot($viewRoot);

    /**
     * Get view root, eg: $prjHome/src/view
     *
     * @return string $viewRoot
     */
    public function getViewRoot();
    
    /**
     * Set view suffix, eg: .php
     *
     * @param string $viewSuffix
     */
    public function setViewSuffix($viewSuffix);
    
    /**
     * Get view suffix, eg: .php
     *
     * @return string $viewSuffix
     */
    public function getViewSuffix();

    /**
     * Asign key => value
     *
     * @param string $key
     * @param mix $value
     * @param bool $secureFilter
     *
     * @return
     */
    public function assign($key, $value, $secureFilter = true);

    /**
     * Render view file don't display
     *
     * @param string $viewFile
     * @param bool $withViewSuffix
     * @param array $data
     *
     * @return string
     */
    public function render($viewFile, $withViewSuffix = false, array $data = array());
}
