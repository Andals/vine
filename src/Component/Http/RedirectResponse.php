<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;

/**
* RedirectResponse represents an HTTP response doing a redirect
*/
class RedirectResponse extends \Vine\Component\Http\Response
{
    /** @var string redirect location url */
    protected $targetUrl;

    /**
     * Create a redirect response
     * @param string  $url     The URL to redirect to
     * @param int     $status  The status code (302 by default)
     * @param array   $headers 
     */
    public function __construct($url, $status = 302)
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('Cannot redirect to an empty URL.');
        }

        parent::__construct('', $status);

        $this->setTargetUrl($url);
    }

    /**
     * {@inheritdoc}
     */
    public static function create($url = '', $status = 302)
    {
        return new static($url, $status);
    }

    /**
     * Returns the target URL
     * @return string target URL
     */
    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    /**
     * Sets the redirect target of this response
     * @param string $url The URL to redirect to
     * return self
     */
    public function setTargetUrl($url)
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('Cannot redirect to an empty URL.');
        }

        $this->targetUrl = $url;

        $this->setContent(
            sprintf('<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="1;url=%1$s" />

        <title>Redirecting to %1$s</title>
    </head>
    <body>
        Redirecting to <a href="%1$s">%1$s</a>.
    </body>
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8')));

        $this->setHeader('Location', $url);

        return $this;        
    }
}
