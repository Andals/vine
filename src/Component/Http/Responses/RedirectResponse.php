<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http\Responses;

use Vine\Component\Http\Request;
use Vine\Component\Http\Request;
use Vine\Component\Http\Responses\ResponseContainerInterface;

/**
* Redirect resposne.
* @author Liang Chao 
*/
class RedirectResponse implements ResponseContainerInterface
{
    
    /** @var string Location */
    protected $location;

    /** @var int Status code */
    protected $status = 302;

    /**
     * Constructor.
     * @param string $location Location
     */
    public function __construct($location) {
        $this->location = $location;
    }


    /**
     * Sets the status code.
     * @param int $status Status code
     * @return self 
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Request $request, Response $response)
    {
        $response->setStatus($this->status);

        $response->setHeader('Location', $this->location);

        $response->sendHeaders();
    }

}


