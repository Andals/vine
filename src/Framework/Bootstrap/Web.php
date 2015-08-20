<?php
/**
* @file Bootstrap.php
* @author ligang
* @version 1.0
* @date 2015-07-30
 */

namespace Vine\Framework\Bootstrap;

/**
    * Web bootstrap
 */
abstract class Web
{/*{{{*/

    /**
        * Run before webApp run
        *
        * @param \Vine\Component\Container\Web container
        *
        * @return 
     */
    abstract public function boot(\Vine\Component\Container\Web $container);
}/*}}}*/
