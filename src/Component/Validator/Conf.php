<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Validator;

/**
* Validator Conf
* @author Liang Chao
*/
class Conf
{
    const KEY_TYPE              = 'type';
    const KEY_DEFAULT           = 'default';
    const KEY_CHECK             = 'check';
    const KEY_CHECK_FUNC        = 'check_func';
    const KEY_CHECK_EXT_PARAMS  = 'check_ext_params';
    const KEY_FILTER_EMPTY      = 'filter_empty';
    const KEY_ERROR             = 'error';
    const KEY_ERROR_ERRNO       = 'errno';
    const KEY_ERROR_MSG         = 'msg';

    private $paramsConf = array();

    /**
     * Sets the param type
     * @param string $name param name
     * @param string $type param type
     * @return self 
     */
    public function setParamType($name, $type)
    {
        $this->paramsConf[$name][self::KEY_TYPE] = $type;
        return $this;
    }    

    /**
     * Gets the param type
     * @param  string $name param name
     * @return string       
     */
    public function getParamType($name)
    {
        return $this->paramsConf[$name][self::KEY_TYPE];
    }

    /**
     * Sets the param default value
     * @param string $name  param name
     * @param mixed $value 
     * @return self 
     */
    public function setParamDefaultValue($name, $value)
    {
        $this->paramsConf[$name][self::KEY_DEFAULT] = $value;
        return $this;
    }

    /**
     * Gets the param default value
     * @param  string $name param name
     * @return mixed   
     */
    public function getParamDefaultValue($name)
    {
        return $this->paramsConf[$name][self::KEY_DEFAULT];
    }

    /**
     * Sets the param check func
     * @param string $name     param name
     * @param callable $callback 
     * @return self 
     */
    public function setParamCheckFunc($name, $callback, $ext = array())
    {
        $this->paramsConf[$name][self::KEY_CHECK][self::KEY_CHECK_FUNC] = $callback;
        $this->paramsConf[$name][self::KEY_CHECK][self::KEY_CHECK_EXT_PARAMS] = $ext;
        return $this;
    }

    /**
     * Gets the param check func
     * @param  string $name param name
     * @return mixed       
     */
    public function getParamCheckFunc($name)
    {
        return isset($this->paramsConf[$name][self::KEY_CHECK][self::KEY_CHECK_FUNC]) ? $this->paramsConf[$name][self::KEY_CHECK][self::KEY_CHECK_FUNC] : '';
    }

    /**
     * Gets the param check rules
     * @param  string $name param name
     * @return array
     */
    public function getParamCheckExtParams($name) 
    {
         return isset($this->paramsConf[$name][self::KEY_CHECK][self::KEY_CHECK_EXT_PARAMS]) ? $this->paramsConf[$name][self::KEY_CHECK][self::KEY_CHECK_EXT_PARAMS] : array();
    }

    /**
     * Sets the param is filter null ?
     * @param string  $name   param name
     * @param boolean $filter is filter null
     * @return self 
     */
    public function setParamFilterNull($name, $filter = true)
    {
        $this->paramsConf[$name][self::KEY_FILTER_EMPTY] = $filter;
        return $this;
    }

    /**
     * Gets the param is filter null
     * @param  string $name param name
     * @return boolean       
     */
    public function getParamFilterNull($name)
    {
        return isset($this->paramsConf[$name][self::KEY_FILTER_EMPTY]) ? $this->paramsConf[$name][self::KEY_FILTER_EMPTY] : false;
    }

    /**
     * Sets the param error exception info
     * @param string $name               param name
     * @param Exception $exceptionClassName exception class
     * @param string $errno              errno
     * @param string $msg                
     * @return self 
     */
    public function setParamExceptionParams($name, $msg = '', $errno)
    {
        $this->paramsConf[$name][self::KEY_ERROR][self::KEY_ERROR_ERRNO] = $errno;
        $this->paramsConf[$name][self::KEY_ERROR][self::KEY_ERROR_MSG] = $msg;
        return $this;
    }

    /**
     * Gets the param error no
     * @param  string $name param name
     * @return string       
     */
    public function getParamErrorErrno($name)
    {
        return $this->paramsConf[$name][self::KEY_ERROR][self::KEY_ERROR_ERRNO];
    }

    /**
     * Gets the param error msg
     * @param  string $name param name
     * @return string       
     */
    public function getParamErrorMsg($name)
    {
        return $this->paramsConf[$name][self::KEY_ERROR][self::KEY_ERROR_MSG];
    }   

    /**
     * Gets the param names
     * @return array 
     */
    public function getParamNames()
    {
        return array_keys($this->paramsConf);
    }

}
