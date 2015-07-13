<?php
/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http\Responses;

use \Vine\Component\Http\Request;
use \Vine\Component\Http\Response;

/**
 * Response container interface
 * @author Liang Chao 
 */
interface ResponseContainerInterface
{

    /**
     * Sends the response.
     * @param  Request  $request  Request instance
     * @param  Response $response Response instance
     */
    public function send(Request $request, Response $response);

}
