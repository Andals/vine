<?php
/**
* @file Bootstrap.php
* @author ligang
* @version 1.0
* @date 2015-07-30
 */

namespace Vine\Component\Bootstrap;

/**
    * Web bootstrap
 */
class Web extends Base
{/*{{{*/

    /**
        * {@inheritdoc}
     */
    final public function boot($container)
    {/*{{{*/
        if (!$container instanceof \Vine\Component\Container\Web) {
            throw new \Exception($container.' must instanceof \Vine\Component\Container\Web');
        }

        parent::boot($container);
    }/*}}}*/
}/*}}}*/
