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

    public function createHttpRequest()
    {
        $url = new \Vine\Component\Http\UrlScript;
        $url->setScheme(!empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'off') ? 'https' : 'http');
        $url->setUser(isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '');
        $url->setPassword(isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '');

        //  HOST & PORT
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

        // PATH & QUERY
        $requestUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $tmp = explode('?', $requestUrl, 2);
        $path = $tmp[0]; // unescape?
        $url->setPath($path);
        $url->setQuery(isset($tmp[1]) ? $tmp[1] : '');

        //  GET, POST
        $query = $url->getQueryParameters();
        $post = empty($_POST) ? array() : $_POST;        
        // TODO: remove invalid characters
        $url->setQuery($query);


        // HEADERS
        $headers = array();
        foreach ($_SERVER as $k => $v) {
            if (strncmp($k, 'HTTP_', 5)) {
                $k = substr($k, 5);
            } elseif (strncmp($k, 'CONTENT_', 8)) {
                continue;
            }
            $headers[ strtr($k, '_', '-') ] = $v;
        }

        $remoteAddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : NULL;
        $remoteHost = isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : NULL;

        // TODO: proxy's remoteaddr remotehost
        
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : NULL;
        if ($method === 'POST' && isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) 
            && preg_match('#^[A-Z]+\z#', $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])
        ) {
            $method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
        }

        // RAW BODY
        $rawBodyCallback = function() {
            static $rawBody;

            if (PHP_VERSION_ID >= 50600) {
                return file_get_contents('php://input');
            } elseif ($rawBody === NULL) {
                $rawBody = (string) file_get_contents('php://input');
            }
            return $rawBody;
        };

        return new \Vine\Component\Http\Request($url, $post, $headers, $method, $remoteAddr, $remoteHost, $rawBodyCallback);
    }
}
