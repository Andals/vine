<?php
/**
* @file Bootstrap.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Component\Bootstrap;

/**
    * Bootstrap base
 */
abstract class Base
{/*{{{*/

    /**
        * Run every protected function which name has prefix init
        *
        * @param mixed container
        *
        * @return 
     */
    public function boot($container)
    {/*{{{*/
        $ref = new \ReflectionClass($this);

        foreach ($ref->getMethods(\ReflectionMethod::IS_PROTECTED) as $method) {
            $func = $method->name;
            if (preg_match('/^init[A-Z]/', $func)) {
                $this->$func($container);
            }
        }
    }/*}}}*/
}/*}}}*/
