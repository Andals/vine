<?php
/**
* @file Base.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Routing\Route;

/**
    * Base route
 */
abstract class Base implements \Vine\Component\Routing\Route\RouteInterface
{/*{{{*/
    protected $userDefined = null;

    /**
        * {@inheritdoc}
     */
    public function setUserDefined($userDefined=null)
    {/*{{{*/
        $this->userDefined = $userDefined;
    }/*}}}*/
}/*}}}*/
