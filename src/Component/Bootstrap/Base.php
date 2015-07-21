<?php
/**
* @file Bootstrap.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Component\Bootstrap;

/**
    * App bootstrap
 */
abstract class Base
{/*{{{*/

    /**
        * Run every protected function which name has prefix init
        *
        * @param \Vine\Component\Loader\Base $loader
        *
        * @return 
     */
    final public function boot(\Vine\Component\Loader\Base $loader)
    {/*{{{*/
        $ref = new \ReflectionClass($this);

        foreach ($ref->getMethods(\ReflectionMethod::IS_PROTECTED) as $method) {
            $func = $method->name;
            if (preg_match('/^init[A-Z]/', $func)) {
                $this->$func($loader);
            }
        }
    }/*}}}*/
}/*}}}*/
