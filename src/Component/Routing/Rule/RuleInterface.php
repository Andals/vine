<?php
/**
* @file Rule.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Routing\Rule;

/**
    * This is route interface
 */
interface RuleInterface
{/*{{{*/

    /**
        * Match rule use request
        *
        * @param $request
        *
        * @return bool
     */
    public function match(\Vine\Component\Http\RequestInterface $request);
}/*}}}*/
