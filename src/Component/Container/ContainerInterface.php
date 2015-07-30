<?php
/**
* @file Container.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Container;

/**
    * This is container interface
 */
interface ContainerInterface
{/*{{{*/

    /**
        * store mix
        *
        * @param mix $mix
        * @param string $key
        *
        * @return bool
     */
    public function add($mix, $key = '');

    /**
        * Get mix
        *
        * @param string $key
        *
        * @return mix
     */
    public function get($key);

    /**
        * Key exists
        *
        * @param $key
        *
        * @return bool
     */
    public function have($key);
}/*}}}*/
