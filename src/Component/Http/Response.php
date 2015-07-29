<?php
/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;

use Vine\Component\Http\Responses\ResponseContainerInterface;

class Response implements \Vine\Component\Http\ResponseInterface
{/*{{{*/

    /** @var \Vine\Component\Http Request instance. */
    protected $request;

    /** @var mixed Response body */
    protected $body;

    /** @var string Response content type */
    protected $contentType = 'text/html';

    /** @var string Response charset. */
    protected $charset;

    /** @var int Status Code. */
    protected $statusCode = 200;

    /** @var array Response headers. */
    protected $headers = array();

    /** @var array Output filters. */
    protected $outputFilters = array();

    /**
     * HTTP status codes.
     *
     * @var array
     */

    protected $statusCodes = array
    (
        // 1xx Informational

        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',

        // 2xx Success

        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',

        // 3xx Redirection

        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        //306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        // 4xx Client Error

        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'There are too many connections from your internet address',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        429 => 'Too Many Requests',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        498 => 'Invalid or expired token',

        // 5xx Server Error

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        530 => 'User access denied',
    );

    public function __construct(\Vine\Component\Http\Request $request, $charset = 'UTF-8')
    {
        $this->request = $request;
        $this->charset = $charset;
    }    

    /**
     * Sets the response body.
     * @param mixed $body $body|Response body
     * @return self 
     */
    public function setBody($body) 
    {
        if ($body instanceof $this) {
            $this->body = $body->getBody();
            $this->statusCode = $body->getStatus();
            $this->outputFilters = array_merge($this->outputFilters, $body->getFilters());
            $this->headers = $this->headers + $body->getHeaders();
        } else {
            $this->body = $body;
        }
        return $this;
    }


    /**
     * Returns the response body.
     * @return mixed 
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * Clears the response body.
     * @return self 
     */
    public function clearBody()
    {
        $this->body = null;
        return $this;
    }


    /**
     * Sets the response content type.
     * @param string $contentType Content type
     * @param string $charset     Charset
     * @return self 
     */
    public function setContentType($contentType, $charset = null)
    {
        $this->contentType = $contentType;

        if ($charset !== null) {
            $this->charset = $charset;
        }

        return $this;
    }


    /**
     * Returns the response content type.
     * @return string 
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Sets the response charset.
     * @param string $charset Charset
     * @return self 
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }


    /**
     * Returns the response charset.
     * @return string 
     */
    public function getCharset()
    {
        return $this->charset;
    }


    /**
     * Sets the HTTP status code.
     * @param int $statusCode HTTP status code
     * @return  self 
     */
    public function setStatus($statusCode)
    {
        if (isset($this->statusCodes[$statusCode])) {
            $this->statusCode = $statusCode;
        }

        return $this;
    }


    /**
     * Return the HTTP status code.
     * @return int 
     */
    public function getStatus()
    {
        return $this->statusCode;
    }


    /**
     * Adds output filter that all output will be passed through before beging sent.
     * @param  Closure $filter Closure used to filter output
     * @return self          
     */
    public function filter(\Closure $filter)
    {
        $this->outputFilters[] = $filter;

        return $this;
    }


    /**
     * Returns the response filters.
     * @return array 
     */
    public function getFilters()
    {
        return $this->outputFilters;
    }


    /**
     * Clears all output filters.
     * @return self 
     */
    public function clearFilters()
    {
        $this->outputFilters = array();

        return $this;
    }


    /**
     * Sets a response header.
     * @param string  $name    Header name
     * @param string  $value   Header value
     * @param boolean $replace Respace origin header?
     * @return self 
     */
    public function setHeader($name, $value, $replace = true)
    {
        $name = strtolower($name);

        if ($replace === true) {
            $this->headers[$name] = array($value);
        } else {
            $headers = isset($this->headers[$name]) ? $this->headers[$name] : array();
            $this->headers[$name] = array_merge($headers, array($value));
        }

        return $this;
    }


    /**
     * Checks if the header exists in the response
     * @param  string  $name Header name
     * @return boolean       
     */
    public function hasHeader($name)
    {
        return isset($this->headers[strtolower($name)]);
    }


    /**
     * Removes a response header.
     * @param  string $name Header name
     * @return self       
     */
    public function removeHeader($name)
    {
        unset($this->headers[strtolower($name)]);

        return $this;
    }


    /**
     * Returns the response headers.
     * @return array 
     */
    public function getHeaders()
    {
        return $this->headers;
    }


    /**
     * Clear the respone headers.
     * @return self 
     */
    public function clearHeaders()
    {
        $this->headers = array();

        return $this;
    }


    /**
     * Clears the response body, filters, headers and so on.
     * @return self 
     */
    public function clear()
    {
        $this->clearBody();
        $this->clearFilters();
        $this->clearHeaders();

        return $this;
    }


    public function sendHeaders()
    {
        $protocal = 'HTTP/1.1';

        header($protocal . ' ' . $this->statusCode . ' ' . $this->statusCodes[$this->statusCode]);

        $contentType = $this->contentType;

        if(stripos($contentType, 'text/') === 0 || in_array($contentType, array('application/json', 'application/xml'))) {
            $contentType .= '; charset=' . $this->charset;
        }

        header('Content-Type: ' . $contentType);        

        // Send other headers

        foreach($this->headers as $name => $headers) {
            foreach($headers as $value) {
                header($name . ': ' . $value, false);
            }
        }
    }


    /**
     * Redirects to another location.
     * @param  string $location Location
     * @return \Vine\Component\Http\Redirect           
     */
    public function redirect($location)
    {
        return new \Vine\Component\Http\Responses\RedirectResponse($location);
    }


    /**
     * Redirects the user back to the previous page.
     * @param  int $statusCode HTTP status code
     * @return \Vine\Component\Http\Responses\Redirect              
     */
    public function back($statusCode = 302)
    {
        return $this->redirect($this->request->getReferer())->setStatus($statusCode);
    }

    /**
     * Return json data of the resposne
     * @param  mixed $data return data
     * @return \Vine\Component\Http\Responses\JsonResponse     
     */
    public function json($data = null)
    {
        return new \Vine\Component\Http\Responses\JsonResponse($data);
    }

    /**
     * Return jsonp data of the response
     * @param  mixed $data     return data
     * @param  string $callback callback name
     * @return \Vine\Component\Http\Responses\JsonResponse        
     */
    public function jsonP($data = null, $callback = '_callback')
    {
        return new \Vine\Component\Http\Responses\JsonResponse($data, $callback);
    }

    public function send()
    {
        if($this->body instanceof ResponseContainerInterface) {
            // This is a response container so we'll just pass it the
            // request and response instances and let it handle the rest itself

            $this->body->send($this->request, $this);
        } else {
            echo $this->body;
        }        
        return $this->body;
    }

}/*}}}*/
