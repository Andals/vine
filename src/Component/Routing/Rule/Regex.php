<?php
/**
* @file Regex.php
* @author ligang
* @version 1.0
* @date 2015-08-13
 */

namespace Vine\Component\Routing\Rule;

/**
    * Implements regex expression rule
 */
class Regex implements RuleInterface
{/*{{{*/
    private $regex = '';

    public function __construct($regex)
    {/*{{{*/
        $this->regex = $regex;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function match(\Vine\Component\Http\RequestInterface $request, \Vine\Component\Routing\Route\RouteInterface $route)
    {/*{{{*/
        if (!preg_match($this->regex, $request->getUrlPath(), $matches)) {
            return false;
        }

        array_shift($matches);
        $route->setActionArgs($matches);

        return true;
    }/*}}}*/
}/*}}}*/
