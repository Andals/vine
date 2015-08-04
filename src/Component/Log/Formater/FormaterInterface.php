<?php
/**
 * @file FormaterInterface.php
 * @author ligang
 * @version 1.0
 * @date 2015-08-04
 */

namespace Vine\Component\Log\Formater;

/**
 * Log formater interface
 */
interface FormaterInterface
{/*{{{*/

    /**
        * fmt message use context
        *
        * @param $message
        * @param $context
        *
        * @return string
     */
    public function fmt($level, $message, array $context = array());
}/*}}}*/
