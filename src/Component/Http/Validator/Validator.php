<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http\Validator;

use Vine\Component\Http\Validator\Conf;
use Vine\Component\Http\Validator\Checker;

/**
 * Validate & Filter HTTP Params
 *
 * @author Liang Chao 
 */
class Validator 
{
    const ERROR_HANDING_EXCEPTION   = 1;
    const ERROR_HANDING_USE_DEFAULT = 2;
    const ERROR_HANDING_DISCARD     = 3;

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
    private function handingParamError($name)
    {
        switch ($this->conf->getParamErrorHanding($name)) {
            case self::ERROR_HANDING_EXCEPTION:
                $exception = $this->conf->getParamErrorExceptionClsname($name);
                throw new $exception($this->conf->getParamErrorErrno($name), $this->conf->getParamErrorMsg($name));
            case self::ERROR_HANDING_USE_DEFAULT:
                $this->requestParams[$name] = $this->conf->getParamDefaultValue($name);
                break;
            case self::ERROR_HANDING_DISCARD:
                default:
        }
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
                    $this->handingParamError($name);
                }
            }
            $this->requestParams[$name] = $value;
        }
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
