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
        * store mixed
        *
        * @param string $key
        * @param mixed $value
        *
        * @return self
     */
    public function add($key, $value);

    /**
        * Get mixed
        *
        * @param string $key
        *
        * @return mixed
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
