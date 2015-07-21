<?php
/**
* @file Base.php
* @author ligang
* @version 1.0
* @date 2015-07-24
 */

namespace Vine\Component\Loader;

abstract class Base
{/*{{{*/
    protected $container = null;

    /**
        * Loader construct
        *
        * @param \Vine\Component\Container\ContainerInterface $container
        *
        * @return 
     */
    public function __construct(\Vine\Component\Container\ContainerInterface $container)
    {/*{{{*/
        $this->container = $container;
    }/*}}}*/
}/*}}}*/
