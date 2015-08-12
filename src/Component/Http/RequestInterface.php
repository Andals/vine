<?php
/**
* @file Request.php
* @author Liang Chao
* @version 1.0
* @date 2015-07-12
 */

namespace Vine\Component\Http;

/**
    * This is request interface
 */
interface RequestInterface
{/*{{{*/

    /** HTTP request method */
    const
        GET = 'GET',
        POST = 'POST',
        HEAD = 'HEAD',
        PUT = 'PUT',
        DELETE = 'DELETE';

    /**
     * Return URL object
     * @return UrlScript 
     */
    public function getUrl();

    /**
     * Get urlPath
     * @return string
     */
    public function getUrlPath();


    /******************* query, post and so on ****************************/

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
     * Returns variable provided to the script via URL query ($_GET).
     * If no key is passed. returns the entire array.
     * @param  string $key     
     * @param  mixed $default value
     * @return mixed          
     */
    public function getQuery($key = null, $default = null);

    /**
     * Returns variable provided to the script via POST method ($_POST).
     * If no key is passed, returns the entire array.
     * @param  string $key     
     * @param  mixed $default value
     * @return mixed         
     */
    public function getPost($key = null, $default = null);

    /**
     * Returns HTTP request method (GET, POST, HEAD, PUT, ...)
     * @return string 
     */
    public function getMethod();

    /**
     * Checks HTTP request method.
     * @param  string  $method 
     * @return boolean    
     */
    public function isMethod($method);

    /**
     * Return the value of the HTTP header. Pass the header name as the 
     * plain, HTTP-specified header name (e.g. 'Accept-Encoding').
     * @param  string $header  
     * @param  mixed $default 
     * @return mixed          
     */
    public function getHeader($header, $default = null);

    /**
     * Returns all HTTP headers.
     * @return array 
     */
    public function getHeaders();

    /**
     * Is the request is sent via secure channel (https).
     * @return boolean 
     */
    public function isSecured();

    /**
     * Is Ajax request?
     * @return boolean 
     */
    public function isAjax();

    /**
     * Returns the IP address of the remote client.
     * @return string|null 
     */
    public function getRemoteAddress();

    /**
     * Returns the host of the remote client.
     * @return string|null 
     */
    public function getRemoteHost();

    /**
     * Returns raw content of HTTP request body.
     * @return string|null 
     */
    public function getRawBody();

}/*}}}*/
