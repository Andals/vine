<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;

use Vine\Component\Http\ResponseFactoryInterface;
use Vine\Component\Http\Response;
use Vine\Component\Http\JsonResponse;
use Vine\Component\Http\RedirectResponse;

/**
* The response factory
*/
class ResponseFactory implements ResponseFactoryInterface
{
    
    public function make($content = '', $status = 200)
    {
        return new Response($content, $status);
    }

    public function json($data = array(), $status = 200)
    {
        return new JsonResponse($data, $status);
    }

    public function jsonp($callback, $data = array(), $status = 200)
    {
        return $this->json($data, $status)->setCallback($callback);
    }

    public function redirect($location = '', $status = 302)
    {
        return new RedirectResponse($location, $status);
    }
}
