<?php

/**
 * This file is part of the Vine Framework 
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;

/**
 * Current HTTP request factory.
 *
 * @author Liang Chao 
 */
class RequestFactory
{
    /**
     * build current request url part
     * @return url instance 
     */
    private function buildRequestUrl() 
    {
        $url = new \Vine\Component\Http\UrlScript;
        $url->setScheme(!empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'off') ? 'https' : 'http');
        $url->setUser(isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '');
        $url->setPassword(isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '');       

        // set host and port
        if ((isset($_SERVER[$tmp = 'HTTP_HOST']) || isset($_SERVER[$tmp = 'SERVER_NAME']))
            && preg_match('#^([a-z0-9_.-]+|\[[a-f0-9:]+\])(:\d+)?\z#i', $_SERVER[$tmp], $pair)
        ) {
            $url->setHost(strtolower($pair[1]));
            if (isset($pair[2])) {
                $url->setPort(substr($pair[2], 1));
            } elseif (isset($_SERVER['SERVER_PORT'])) {
                $url->setPort($_SERVER['SERVER_PORT']);
            }
        }         

        // set path and query
        $requestUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $tmp = explode('?', $requestUrl, 2);
        $path = $tmp[0]; // unescape?
        $url->setPath($path);
        $url->setQuery(isset($tmp[1]) ? $tmp[1] : '');  
        return $url;      
    }

    /**
     * build current request header part
     * @return array 
     */
    private function buildRequestHeader()
    {
        $headers = array();
        foreach ($_SERVER as $k => $v) {
            if (strncmp($k, 'HTTP_', 5)) {
                $k = substr($k, 5);
            } elseif (strncmp($k, 'CONTENT_', 8)) {
                continue;
            }
            $headers[ strtr($k, '_', '-') ] = $v;
        }        
        return $headers;
    }

    /**
     * build current request method part
     * @return string 
     */
    private function buildRequestMethod()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
        if ($method === 'POST' && isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) 
            && preg_match('#^[A-Z]+\z#', $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])
        ) {
            $method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
        }
        return $method;        
    }

    /**
     * factory to create current request instance
     * @return request instance 
     */
    public function createHttpRequest()
    {
        $url = $this->buildRequestUrl();
        $post = empty($_POST) ? array() : $_POST; 
        $headers = $this->buildRequestHeader();
        $method = $this->buildRequestMethod();
        $remoteAddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
        $remoteHost = isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : null;
        $rawBody = file_get_contents('php://input');
        return new \Vine\Component\Http\Request($url, $post, $headers, $method, $remoteAddr, $remoteHost, $rawBody);
    }
}
