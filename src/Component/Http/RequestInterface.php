<?php
/**
* @file Request.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Http;

/**
    * This is request interface
 */
interface RequestInterface
{/*{{{*/

    /**
        * Get param value from http request
        *
        * @param string $key
        * @param by input $default
        *
        * @return 
     */
    public function getParam($key, $default = null);

    /**
        * Get http uri, same as nginx's $uri($request_uri without query string)
        *
        * @return string
     */
    public function getUri();

    /**
        * Get http request query string
        *
        * @return 
     */
    public function getQueryString();
}/*}}}*/
