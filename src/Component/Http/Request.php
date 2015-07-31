<?php
/**
* @file Request.php
* @author Liang Chao
* @version 1.0
* @date 2015-07-12
 */

namespace Vine\Component\Http;

/**
    * This is default request
 */
class Request implements RequestInterface
{/*{{{*/

    /** @var string */
    private $method;

    /** @var UrlScript */
    private $url;

    /** @var array */
    private $post;

    /** @var array */
    private $headers;

    /** @var string|null */
    private $remoteAddress;

    /** @var string|null */
    private $remoteHost;

    /** @var string|null */
    private $rawBody;

    public function __construct(UrlScript $url, $post = null, $headers = null, $method = null, $remoteAddress = null, $remoteHost = null, $rawBody = null) 
    {
        $this->url = $url;
        $this->post = (array) $post;
        $this->headers = array_change_key_case((array) $headers, CASE_LOWER);
        $this->method = $method ?: 'GET';
        $this->remoteAddress = $remoteAddress;
        $this->remoteHost = $remoteHost;
        $this->rawBody = $rawBody;
    }


    /**
     * Returns URL object.
     * @return UrlScript 
     */
    public function getUrl()
    {
        return clone $this->url;
    }


    /**************** query, post and so on *************************/


    /**
     * Returns variable provided to the script via URL query ($_GET).
     * If no key is passed, returns the entire array.
     * @param  string $key     
     * @param  mixed $default 
     * @return mixed          
     */
    public function getQuery($key = null, $default = null)
    {
        if (func_num_args() === 0) {
            return $this->url->getQueryParameters();
        } else {
            return $this->url->getQueryParameter($key, $default);
        }
    }

    /**
     * Returns variable provided to the script via POST method ($_POST).
     * If no key is passed, returns the entire array.
     * @param  string $key     
     * @param  mixed $default 
     * @return mixed          
     */
    public function getPost($key = null, $default = null)
    {
        if (func_num_args() === 0) {
            return $this->post;
        } elseif (isset($this->post[$key])) {
            return $this->post[$key];
        } else {
            return $default;
        }
    }

    /**
     * Returns variable provided to the script via GET & POST method ($GET & $POST).
     * If no key is passed, returns the entire array
     * @param  string $key     
     * @param  mixed $default 
     * @return mixed          
     */
    public function getParam($key = null, $default = null)
    {
        if ($key === null) {
            return array_merge($_GET, $_POST);
        }
        $value = $default;
        if (isset($_GET[$key])) {
            $value = $_GET[$key];
        } else if (isset($_POST[$key])) {
            $value = $_POST[$key];
        } 
        return $value;
    }

    /********************* method & headers ****************d*g**/


    /**
     * Returns HTTP request method (GET, POST, HEAD, PUT, ...). The method is case-sensitive.
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }


    /**
     * Checks if the request method is the given one.
     * @param  string
     * @return bool
     */
    public function isMethod($method)
    {
        return strcasecmp($this->method, $method) === 0;
    }


    /**
     * @deprecated
     */
    public function isPost()
    {
        return $this->isMethod('POST');
    }

    /**
     * Return the value of the HTTP header. Pass the header name as the
     * plain, HTTP-specified header name (e.g. 'Accept-Encoding').
     * @param  string
     * @param  mixed
     * @return mixed
     */
    public function getHeader($header, $default = null)
    {
        $header = strtolower($header);
        return isset($this->headers[$header]) ? $this->headers[$header] : $default;
    }


    /**
     * Returns all HTTP headers.
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }


    /**
     * Returns referrer.
     * @return Url|null
     */
    public function getReferer()
    {
        return isset($this->headers['referer']) ? new \Vine\Component\Http\Url($this->headers['referer']) : null;
    }


    /**
     * Is the request is sent via secure channel (https).
     * @return bool
     */
    public function isSecured()
    {
        return $this->url->getScheme() === 'https';
    }


    /**
     * Is AJAX request?
     * @return bool
     */
    public function isAjax()
    {
        return $this->getHeader('X-Requested-With') === 'XMLHttpRequest';
    }


    /**
     * Returns the IP address of the remote client.
     * @return string|null
     */
    public function getRemoteAddress()
    {
        return $this->remoteAddress;
    }


    /**
     * Returns the host of the remote client.
     * @return string|null
     */
    public function getRemoteHost()
    {
        if ($this->remoteHost === null && $this->remoteAddress !== null) {
            $this->remoteHost = getHostByAddr($this->remoteAddress);
        }
        return $this->remoteHost;
    }    

    /**
     * Returns raw content of HTTP request body.
     * @return string|null
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }    

}/*}}}*/
