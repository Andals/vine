<?php
/**
* @file Response.php
* @author ligang
* @version 1.0
* @date 2015-07-08
 */

namespace Vine\Component\Http;

/**
    * This is default response
 */
class Response implements ResponseInterface
{/*{{{*/
    private $body = '';

    /**
        * {@inheritdoc}
     */
    public function setHeader($key, $value)
    {/*{{{*/
        header("$key: $value");
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function setBody($body)
    {/*{{{*/
        $this->body = $body;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function send()
    {/*{{{*/
        echo $this->body;
    }/*}}}*/
}/*}}}*/
