<?php
/**
* @file Response.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Http;

/**
    * This is response interface
 */
interface ResponseInterface
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
        * Set content
        *
        * @param mixed content
        *
        * @return 
     */
    public function setContent($content);

    /**
        * Send response to client
        *
        * @return 
     */
    public function send();
}/*}}}*/
