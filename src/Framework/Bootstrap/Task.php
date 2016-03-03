<?php
/**
* @file Task.php
* @brief Task bootstrap
* @author ligang
* @version 
* @date 2016-02-24
 */

namespace Vine\Framework\Bootstrap;

/**
    * General bootstrap
 */
abstract class Task
{/*{{{*/

    /**
        * Run before taskApp run
        *
        * @param \Vine\Component\Container\Task container
        *
        * @return 
     */
    abstract public function boot(\Vine\Component\Container\Task $container);
}/*}}}*/
