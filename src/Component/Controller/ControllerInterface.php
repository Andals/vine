<?php
/**
* @file Controller.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Controller;

/**
    * This is controller interface
 */
interface ControllerInterface
{/*{{{*/

    /**
        * Controller dispatch, run mvc
        *
        * @param string $actionName
        * @param \Vine\Component\Http\RequestInterface $request
        * @param \Vine\Component\Http\ResponseInterface $response
        *
        * @return 
     */
    public function dispatch($actionName, \Vine\Component\Http\RequestInterface $request, \Vine\Component\Http\ResponseInterface $response);
}/*}}}*/
