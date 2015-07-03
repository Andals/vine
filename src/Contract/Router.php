<?php
/**
* @file Router.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Contract;

/**
    * This is router interface
 */
interface Router
{/*{{{*/

    /**
        * find route by request
        *
        * @param \Vine\Contract\Request $request
        *
        * @return \Vine\Contract\Route
     */
    public function findRoute(\Vine\Contract\Request $request);
}/*}}}*/
