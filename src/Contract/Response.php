<?php
/**
* @file Response.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Contract;

/**
    * This is response interface
 */
interface Response
{/*{{{*/

    /**
        * Set header
        *
        * @param string $key
        * @param string $value
        *
        * @return 
     */
    public function setHeader($key, $value);

    /**
        * Set body
        *
        * @param string $body
        *
        * @return 
     */
    public function setBody($body);

    /**
        * Send response to client
        *
        * @return 
     */
    public function send();
}/*}}}*/
