<?php
/**
* @file Router.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Routing;

/**
    * This is router interface
 */
interface RouterInterface
{/*{{{*/

    /**
        * find route by request
        *
        * @param \Vine\Component\Http\RequestInterface $request
        *
        * @return \Vine\Component\Routing\RouteInterface
     */
    public function findRoute(\Vine\Component\Http\RequestInterface $request);
}/*}}}*/
