<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Validator;

use Vine\Component\Validator\Conf;
use Vine\Component\Validator\Checker;
use Vine\Component\Validator\ParamException;

/**
 * Validate & Filter HTTP Params
 *
 * @author Liang Chao 
 */
class Validator 
{
    const TYPE_STR = 1;
    const TYPE_NUM = 2;
    const TYPE_ARR = 3;           

    public $conf;
    private $request;
    private $requestParams = array();

    public function __construct(\Vine\Component\Http\RequestInterface $request)
    {
        $this->request = $request;
        $this->conf = new Conf();
    }

    /**
     * Gets the validator conf
     * @return \Vine\Component\Http\Validator\Conf
     */
    public function getConf()
    {
        return $this->conf;
    }

    /**
     * Gets the request params
     * @param  string $key     params key
     * @param  mixed $default  default value
     * @return mixed          
     */
    private function getParam($key, $default = null)
    {
        return $this->request->getParam($key, $default);
    }    

    /**
     * Gets the string format request params
     * @param  string $key     params key
     * @param  mixed $default default value
     * @return mixed          
     */
    private function getStrParam($key, $default = '')
    {
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : trim($value);
    }

    /**
     * Gets the number format request params
     * @param  string  $key     params key
     * @param  mixed $default default value
     * @return mixed           
     */
    private function getNumParam($key, $default = 0)
    {
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : intval($value);
    }

    /**
     * Gets the array format request params
     * @param  string $key     params key
     * @param  mixed  $default default value
     * @return mixed          
     */
    private function getArrParam($key, $default = array())
    {
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : $this->fmtArrValue($value);
    }

    /**
     * format the array params
     * @param  mixed $value 
     * @return array        
     */
    private function fmtArrValue($value)
    {
        foreach ($value as $k => $v) {
            if (is_array($v)) {
                $v = $this->fmtArrValue($v);
            } else {
                $v = trim($v);
            }
            $value[$k] = $v;
        }
        return $value;
    }    

    /**
     * parse the params value
     * @param  string $name param name
     * @return mixed       
     */
    private function parseParamValue($name)
    {
        $default = $this->conf->getParamDefaultValue($name);

        switch ($this->conf->getParamType($name)) {
            case self::TYPE_STR:
                return $this->getStrParam($name, $default);
            case self::TYPE_NUM:
                return $this->getNumParam($name, $default);
            case self::TYPE_ARR:
                return $this->getArrParam($name, $default);
            default:
                return $this->getParam($name, $default);
        }
    }    

    /**
     * deal the param error handle
     * @param  string $name param name
     */
    private function handingParamException($name)
    {
        $message = $this->conf->getParamErrorMsg($name);
        $errorno = $this->conf->getParamErrorErrno($name);
        throw new ParamException($message, $errorno);
    }        

    /**
     * parse the params to requestParams use conf regular
     */
    public function parseRequestParams()
    {
        foreach ($this->conf->getParamNames() as $name) {
            $value = $this->parseParamValue($name);
            if (is_null($value) && $this->conf->getParamFilterNull($name)) {
                continue;
            }

            $check = $this->conf->getParamCheckFunc($name);
            if (is_callable($check)) {
                if (!call_user_func($check, $value)) {
                    $this->handingParamException($name);
                }
            }
            $this->requestParams[$name] = $value;
        }

        return $this->requestParams;
    }    

    /**
     * Gets the request params
     * @return array 
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }        
}