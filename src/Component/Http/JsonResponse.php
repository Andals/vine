<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;

/**
* Response represents an HTTP response in JSON format.
*/
class JsonResponse extends Response
{
    protected $data;
    protected $callback;
    
    /**
     * Constructor
     * @param mixed   $data    The response data
     * @param int     $status  The response status code
     * @param array   $headers An array of response headers
     */
    public function __construct($data = null, $status = 200)
    {
        parent::__construct('', $status);

        if ($data === null) {
            $data = array();
        }
        $this->setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public static function create($data = null, $status = 200)
    {
        return new static($data, $status);
    }

    /**
     * Sets the JSONP callback
     * @param string|null $callback The JSONP callback or null to use none
     */
    public function setCallback($callback = null)
    {
        if ($callback !== null) {
            // taken from http://www.geekality.net/2011/08/03/valid-javascript-identifier/
            $pattern = '/^[$_\p{L}][$_\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Pc}\x{200C}\x{200D}]*+$/u';
            $parts = explode('.', $callback);
            foreach ($parts as $part) {
                if (!preg_match($pattern, $part)) {
                    throw new \InvalidArgumentException('The callback name is not valid.');
                }
            }
        }

        $this->callback = $callback;     

        return $this->update();   
    }    

    /**
     * Sets the data to be sent as JSON
     * @param mixed $data 
     */
    public function setData($data = array())
    {
        try {
            $data = @json_encode($data);
        } catch (\Exception $e) {
            throw $e;
        }
        $this->data = $data;

        return $this->update();        
    }

    /**
     * Updates the content and headers according to the JSON data and callback.
     * @return JsonResponse 
     */
    protected function update()
    {
        if ($this->callback !== null) {
            $this->setContentType('text/javascript');
            return $this->setContent(sprintf('/**/%s(%s);', $this->callback, $this->data));
        } 

        if (!$this->hasHeader('Content-Type') || $this->getContentType() === 'text/javascript') {
            $this->setContentType('text/plain');
        }

        return $this->setContent($this->data);
    }
}
