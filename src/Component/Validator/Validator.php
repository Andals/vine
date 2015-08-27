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

    private $conf;
    private $filterConf;
    private $filteredParams = array();

    public function __construct()
    {
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
        return isset($this->filterConf[$key]) ? $this->filterConf[$key] : $default;
    }    

    /**
     * Sets the filter conf
     * @param mixed $conf 
     */
    public function setFilterParams($conf) 
    {
        $this->filterConf = $conf;
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
     * parse the params to filteredParams use conf regular
     */
    public function filterParams($originParams)
    {
        $this->setFilterParams($originParams);
        foreach ($this->conf->getParamNames() as $name) {
            $value = $this->parseParamValue($name);
            if (is_null($value) && $this->conf->getParamFilterNull($name)) {
                continue;
            }

            $checkerFunc = $this->conf->getParamCheckFunc($name);
            $checkerExtParams = $this->conf->getParamCheckExtParams($name);
            $checkerParams = array_unshift($checkerExtParams, $value);

            if (is_callable($checkerFunc)) {
                if (!call_user_func_array($checkerFunc, $checkerParams)) {
                    $this->handingParamException($name);
                }
            }
            $this->filteredParams[$name] = $value;
        }

        return $this->filteredParams;
    }    

    /**
     * Gets the request params
     * @return array 
     */
    public function getFilteredParams()
    {
        return $this->filteredParams;
    }        
}
