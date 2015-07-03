<?php
/**
* @file Controller.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Contract;

/**
    * This is controller interface
 */
interface Controller
{/*{{{*/

    /**
        * Controller dispatch, run mvc
        *
        * @param string $actionName
        * @param \Vine\Contract\Request $request
        *
        * @return 
     */
    public function dispatch($actionName, \Vine\Contract\Request $request);
}/*}}}*/
