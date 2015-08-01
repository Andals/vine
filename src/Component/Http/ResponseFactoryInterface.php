<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;


interface ResponseFactoryInterface
{
    /**
     * Return a new response from the application.
     *
     * @param  string  $content
     * @param  int  $status
     */
    public function make($content = '', $status = 200);    

    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array  $data
     * @param  int  $status
     */
    public function json($data = array(), $status = 200);    


    /**
     * Return a new JSONP response from the application.
     *
     * @param  string  $callback
     * @param  string|array  $data
     * @param  int  $status
     */
    public function jsonp($callback, $data = array(), $status = 200);    


    /**
     * Create a new redirect response to the given location.
     *
     * @param  string  $location
     * @param  int  $status
     */
    public function redirect($location, $status = 302);    
}
