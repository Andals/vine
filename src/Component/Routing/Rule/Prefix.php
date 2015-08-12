<?php
/**
* @file Prefix.php
* @author ligang
* @version 1.0
* @date 2015-08-13
 */

namespace Vine\Component\Routing\Rule;

/**
    * Implements prefix string rule
 */
class Prefix implements RuleInterface
{/*{{{*/
    private $prefix = '';

    public function __construct($prefix)
    {/*{{{*/
        $this->prefix = $prefix;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function match(\Vine\Component\Http\RequestInterface $request, &$actionArgs = array())
    {/*{{{*/
        return strpos($request->getUrlPath(), $this->prefix) !== false ? true : false;
    }/*}}}*/
}/*}}}*/
