<?php
/**
* @file Request.php
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Component\Http;

/**
    * This is default request
 */
class Request implements RequestInterface
{/*{{{*/

    /**
        * {@inheritdoc}
     */
    public function getParam($key, $default = null)
    {/*{{{*/
        $value = null;

        if (isset($_GET[$key])) {
            $value = $_GET[$key];
        } else if (isset($_POST[$key])) {
            $value = $_POST[$key];
        } else {
            $value = $default;
        }

        return $value;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function getUri()
    {/*{{{*/
        $requestUri  = $_SERVER['REQUEST_URI'];
        $queryString = $this->getQueryString();

        if ('' == $queryString) {
            return $requestUri;
        }

        preg_match('/^([^?]+)/', $requestUri, $matches);
        return $matches[1];
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function getQueryString()
    {/*{{{*/
        return $_SERVER['QUERY_STRING'];
    }/*}}}*/
}/*}}}*/
