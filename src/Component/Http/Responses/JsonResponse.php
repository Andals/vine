<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http\Responses;

use Vine\Component\Http\Request;
use Vine\Component\Http\Response;
use Vine\Component\Http\Responses\ResponseContainerInterface;

/**
* Redirect resposne.
* @author Liang Chao 
*/
class JsonResponse implements ResponseContainerInterface
{
    

    /** @var int Status code */
    protected $status = 200;

    /** @var mixed data */
    protected $data;

    /** @var string callback name */
    protected $callback;



    /**
     * Constructor.
     * @param string $location Location
     */
    public function __construct($data = null, $callback = null) {
        $this->data = $data;
        if ($data === null) {
            $data = [];
        }

        $this->setData($data);
        $this->setCallback($callback);
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
     * Sets the response data.
     * @param mixed $data 
     * @return self 
     */
    public function setData($data = array())
    {
        try {
            $data = @json_encode($data);
        } catch (\Exception $e) {
            throw $e;
        }
        $this->data = $data;

        return $this;
    }

    public function setCallback($callback = null) {
        if (null !== $callback) {
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

        return $this;   
    }

    /**
     * {@inheritdoc}
     */
    public function send(Request $request, Response $response)
    {
        $response->setStatus($this->status);
        if ($this->callback !== null) {
            $response->setContentType('text/javascript');
            $response->setBody(sprintf('/**/%s(%s);', $this->callback, $this->data));
        } else {
            $response->setContentType('application/json');
            $response->setBody($this->data);
        }  

        $response->send();
    }

}


