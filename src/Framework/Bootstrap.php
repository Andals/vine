<?php
/**
* @file Bootstrap.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Framework;

/**
    * App bootstrap
 */
class Bootstrap
{/*{{{*/

    /**
        * Run every protected function which name has prefix init
        *
        * @param \Vine\Framework\Loader $loader
        *
        * @return 
     */
    final public function boot(\Vine\Framework\Loader $loader)
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
