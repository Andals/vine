<?php
/**
* @file View.php
* @author ligang
* @version 1.0
* @date 2015-07-06
 */

namespace Vine\Component\View;

/**
 * This is view interface
 */
interface ViewInterface
{/*{{{*/

    /**
     * Set view root, eg: $prjHome/src/view
     *
     * @param string $viewRoot
     *
     * @return 
     */
	public function setViewRoot($viewRoot);
	
	/**
	 * Get view root, eg: $prjHome/src/view
	 *
	 * @return string $viewRoot
	 */
	public function getViewRoot();

    /**
     * Asign key => value
     *
     * @param string $key
     * @param mix $value
     * @param bool $secureFilter
     *
     * @return
     *
     */
    public function assign($key, $value, $secureFilter = true);

    /**
     * Render view file don't display
     *
     * @param string $viewFile
     * @param array $data
     *
     * @return string
     */
    public function render($viewFile, array $data = array());

}/*}}}*/
