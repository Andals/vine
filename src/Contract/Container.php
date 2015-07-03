<?php
/**
* @file Container.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Contract;

/**
    * This is container interface
 */
interface Container
{/*{{{*/

    /**
        * store obj
        *
        * @param obj $obj
        * @param string $key
        *
        * @return bool
     */
    public function add($obj, $key='');

    /**
        * get obj
        *
        * @param string $key
        *
        * @return obj depend on your saved
     */
    public function get($key);
}/*}}}*/
