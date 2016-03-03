<?php
/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;

class Response implements \Vine\Component\Http\ResponseInterface
{/*{{{*/

    /** @var string Response content */
    protected $content;

    /** @var string Response content type */
    protected $contentType = 'text/html';

    /** @var string Response charset. */
    protected $charset;

    /** @var string Response protocol version */
    protected $version;

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
    (/*{{{*/
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
    );/*}}}*/
    
    /**
     * Constructor
     * @param mixed  $content  The resposne content
     * @param int $status      The response status code
     * @param array   $headers An array of response headers
     */
    public function __construct($content = '', $status = 200)
    {
        $this->setContent($content);
        $this->setStatus($status);
        $this->setProtocolVersion('1.1');
    }    

    /**
     * Factory method
     */
    public static function create($content = '', $status = 200)
    {
        return new static($content, $status);
    }    

    /**
     * Sets the response content.
     * @param mixed $content
     * @return self 
     */
    public function setContent($content) 
    {
        $this->content = (string) $content;
        return $this;
    }


    /**
     * Returns the response content.
     * @return mixed 
     */
    public function getContent()
    {
        return $this->content;
    }


    /**
     * Clears the response content.
     * @return self 
     */
    public function clearContent()
    {
        $this->content = null;
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
     * Sets the HTTP protocal version (1.0 or 1.1)
     * @param string $version The HTTP protocal version
     * @return self 
     */
    public function setProtocolVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Gets the HTTP protocol version
     * @return string 
     */
    public function getProtocolVersion()
    {
        return $this->version;
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
            $this->headers[$name] = $value;
        } else {
            $headers = isset($this->headers[$name]) ? $this->headers[$name] : '';
            $this->headers[$name] = array_merge($headers, $value);
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
     * Return the response header for key
     * @param  string $name 
     * @return string       
     */
    public function getHeader($name)
    {
        return isset($this->headers[$name]) ? $this->headers[$name] : '';
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
        $this->clearContent();
        $this->clearFilters();
        $this->clearHeaders();

        return $this;
    }

    /**
     * send response headers
     * @return null 
     */
    public function sendHeaders()
    {
        ob_flush();
        
        // headers have already been send by the developer
        if (headers_sent()) {
            return $this;
        }

        header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusCodes[$this->statusCode]), true, $this->statusCode);    

        $contentType = $this->contentType;

        if(stripos($contentType, 'text/') === 0 || in_array($contentType, array('application/json', 'application/xml'))) {
            $contentType .= '; charset=' . $this->charset;
        }

        header('Content-Type: ' . $contentType); 

        foreach($this->headers as $name => $headers) {
            if (!is_array($headers)) {
                $headers = array($headers);
            }
            foreach($headers as $value) {
                header($name . ': ' . $value, false, $this->statusCode);
            }
        }
        return $this;
    }

    /**
     * Sends content for the current web response.
     * @return self 
     */
    public function sendContent()
    {
        $this->content = (string) $this->content;

        foreach ($this->outputFilters as $outputFilter) {
            $this->content = $outputFilter($this->content);
        }

        echo $this->content;        

        return $this;
    }

    /**
     * Is response invalid?
     * http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     * @return boolean 
     */
    public function isInvalidStatusCode()
    {
        return $this->statusCode < 100 || $this->statusCode >= 600;
    }

    /**
     * Is response successful?
     * @return boolean 
     */
    public function isSuccessful()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function isRedirection()
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    /**
     * Send the response body
     * @return self 
     */
    public function send()
    {
        if (ob_get_level() === 0) {
            ob_start();
        }

        $this->sendHeaders();
        $this->sendContent();

        ob_end_flush();

        return $this;
    }

}/*}}}*/
