<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;

/**
 * URI Syntax (RFC 3986).
 *
 * <pre>
 * scheme  user  password  host  port  basePath   relativeUrl
 *   |      |      |        |      |    |             |
 * /--\   /--\ /------\ /-------\ /--\/--\/----------------------------\
 * http://john:x0y17575@vine.org:8042/en/manual.php?name=param#fragment  <-- absoluteUrl
 *        \__________________________/\____________/^\________/^\______/
 *                     |                     |           |         |
 *                 authority               path        query    fragment
 * </pre>
 *
 * - authority:   [user[:password]@]host[:port]
 * - hostUrl:     http://user:password@vine.org:8042
 * - basePath:    /en/ (everything before relative URI not including the script name)
 * - baseUrl:     http://user:password@vine.org:8042/en/
 * - relativeUrl: manual.php
 *
 * @author     Liang Chao
 *
 * @property   string $scheme
 * @property   string $user
 * @property   string $password
 * @property   string $host
 * @property   int $port
 * @property   string $path
 * @property   string $query
 * @property   string $fragment
 * @property-read string $absoluteUrl
 * @property-read string $authority
 * @property-read string $hostUrl
 * @property-read string $basePath
 * @property-read string $baseUrl
 * @property-read string $relativeUrl
 * @property-read array $queryParameters
 */
class Url 
{
    /** @var array */
    // FIXED: 改为Const
    public static $defaultPorts = array(
        'http' => 80,
        'https' => 443,
        'ftp' => 21,
    );

    /** @var string */
    private $scheme = '';

    /** @var string */
    private $user = '';

    /** @var string */
    private $password = '';

    /** @var host */
    private $host = '';

    /** @var int */
    private $port;

    /** @var string */
    private $path = '';

    /** @var query */
    private $query = array();

    /** @var string */
    private $fragment = '';

    /**
     * @param string|self $url
     * @throws \InvalidArgumentException if URL is malformed
     */
    public function __construct($url = null) 
    {
        if (is_string($url)) {
            $p = @parse_url($url); // @ - is escalated to exception
            if ($p === false) {
                throw new \InvalidArgumentException("Malformed or unsupported URI '$url'.");
            }

            $this->scheme = isset($p['scheme']) ? $p['scheme'] : '';
            $this->user = isset($p['user']) ? rawurldecode($p['user']) : '';
            $this->password = isset($p['pass']) ? rawurldecode($p['pass']) : '';
            $this->host = isset($p['host']) ? rawurldecode($p['host']) : '';
            $this->port = isset($p['port']) ? $p['port'] : null;
            $this->setPath(isset($p['path']) ? $p['path'] : '');
            $this->setQuery(isset($p['query']) ? $p['query'] : array());
            $this->fragment = isset($p['fragment']) ? rawurldecode($p['fragment']) : '';

        } 
    }


    /**
     * Sets the scheme part of URI
     * @param string $value 
     * @return self 
     */
    public function setScheme($value)
    {
        $this->scheme = (string) $value;
        return $this;
    }


    /**
     * Returns the scheme part of URI
     * @return string 
     */
    public function getScheme()
    {
        return $this->scheme;
    }


    /**
     * Sets the user name part of URI
     * @param string $value 
     * @return self 
     */
    public function setUser($value)
    {
        $this->user = (string) $value;
        return $this;
    }


    /**
     * Returns the user name part of URI
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Sets the password part of URI
     * @param string $value 
     * @return self 
     */
    public function setPassword($value)
    {
        $this->password = (string) $value;
        return $this;
    }


    /**
     * Returns the password part of URI
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Sets the host part of URI
     * @param string $value 
     * @return self 
     */
    public function setHost($value)
    {
        $this->host = (string) $value;
        $this->setPath($this->path);
        return $this;
    }


    /**
     * Return the host part of URI
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }


    /**
     * Sets the port part of URI
     * @param int $value 
     * @return self 
     */
    public function setPort($value)
    {
        $this->port = (int) $value;
        return $this;
    }


    /**
     * Returns the port part of URI
     * @return int 
     */
    public function getPort()
    {
        return $this->port
            ? $this->port
            : (isset(self::$defaultPorts[$this->scheme]) ? self::$defaultPorts[$this->scheme] : null);
    }


    /**
     * Sets the path part of URI
     * @param string $value 
     * @return self 
     */
    public function setPath($value)
    {
        $this->path = (string) $value;
        if ($this->host && substr($this->path, 0, 1) !== '/') {
            $this->path = '/' . $this->path;
        }
        return $this;
    }


    /**
     * Returns the path part of URI
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * Sets the query part of URI
     * @param string|array $value 
     * @return self 
     */
    public function setQuery($value)
    {
        $this->query = is_array($value) ? $value : self::parseQuery($value);
        return $this;
    }


    /**
     * Appends the query part of URI
     * @param  string|array $value 
     * @return self        
     */
    public function appendQuery($value)
    {
        $this->query = is_array($value)
            ? $value + $this->query
            : self::parseQuery($this->getQuery() . '&' . $value);
        return $this;
    }


    /**
     * Returns the query part of URI
     * @return string 
     */
    public function getQuery()
    {
        return http_build_query($this->query);
    }


    /**
     * Returns the query array of URI
     * @return array 
     */
    public function getQueryParameters()
    {
        return $this->query;
    }


    /**
     * Returns the query from key
     * @param  string $name    
     * @param  $default mixed null unsets the parameter
     * @return self          
     */
    public function getQueryParameter($name, $default = null)
    {
        return isset($this->query[$name]) ? $this->query[$name] : $default;
    }


    /**
     * Sets the query from key
     * @param string $name  
     * @param string $value 
     * @return self 
     */
    public function setQueryParameter($name, $value)
    {
        $this->query[$name] = $value;
        return $this;
    }


    /**
     * Sets the fragment part of URI
     * @param string $value 
     * @return self 
     */
    public function setFragment($value)
    {
        $this->fragment = (string) $value;
        return $this;
    }


    /**
     * Returns the fragment part of URI
     * @return string 
     */
    public function getFragment()
    {
        return $this->fragment;
    }


    /**
     * Returns the entire URI including query string and fragment.
     * @return string 
     */
    public function getAbsoluteUrl()
    {
        return $this->getHostUrl() . $this->path
            . (($tmp = $this->getQuery()) ? '?' . $tmp : '')
            . ($this->fragment === '' ? '' : '#' . $this->fragment);
    }


    /**
     * Returns the [user[:pass]@]host[:port] part of URI.
     * @return string
     */
    public function getAuthority()
    {
        return $this->host === ''
            ? ''
            : ($this->user !== '' && $this->scheme !== 'http' && $this->scheme !== 'https'
                ? rawurlencode($this->user) . ($this->password === '' ? '' : ':' . rawurlencode($this->password)) . '@'
                : '')
            . $this->host
            . ($this->port && (!isset(self::$defaultPorts[$this->scheme]) || $this->port !== self::$defaultPorts[$this->scheme])
                ? ':' . $this->port
                : '');
    }


    /**
     * Returns the scheme and authority part of URI.
     * @return string
     */
    public function getHostUrl()
    {
        return ($this->scheme ? $this->scheme . ':' : '') . '//' . $this->getAuthority();
    }


            /**
     * Returns the base-path.
     * @return string
     */
    public function getBasePath()
    {
        $pos = strrpos($this->path, '/');
        return $pos === false ? '' : substr($this->path, 0, $pos + 1);
    }


    /**
     * Returns the base-URI.
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getHostUrl() . $this->getBasePath();
    }


    /**
     * Returns the relative-URI.
     * @return string
     */
    public function getRelativeUrl()
    {
        return (string) substr($this->getAbsoluteUrl(), strlen($this->getBaseUrl()));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getAbsoluteUrl();
    }

    /**
     * Parses query string.
     * @return array
     */
    public static function parseQuery($s)
    {
        parse_str($s, $res);
        return $res;
    }    
}
