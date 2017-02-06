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
    const TYPE_STR   = 1;
    const TYPE_NUM   = 2;
    const TYPE_ARR   = 3;
    const TYPE_FLOAT = 4;

    private $conf;

    private $filterParams = array();

    public function __construct()
    {
        $this->conf = new Conf();
    }

    /**
     * Gets the validator conf
     * @return \Vine\Component\Validator\Conf
     */
    public function getConf()
    {
        return $this->conf;
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
        $filter = $this->conf->getParamsFilter();
        if (is_null($filter)) {
            $filter = new ExceptionFilter();
        }
        $this->filterParams = $filter->filterParams($this->conf, $originParams);

        return $this->filterParams;
    }

    /**
     * Gets the request params
     * @return array
     */
    public function getFilterParams()
    {
        return $this->filterParams;
    }
}
