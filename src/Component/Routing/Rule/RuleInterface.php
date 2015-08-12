<?php
/**
* @file RuleInterface.php
* @author ligang
* @version 1.0
* @date 2015-08-13
 */

namespace Vine\Component\Routing\Rule;

/**
    * This is rule interface
 */
interface RuleInterface
{/*{{{*/

    /**
        * Match rule use request
        *
        * @param \Vine\Component\Http\RequestInterface $request
        * @param array $actionArgs
        *
        * @return bool
     */
    public function match(\Vine\Component\Http\RequestInterface $request, &$actionArgs = array());
}/*}}}*/
