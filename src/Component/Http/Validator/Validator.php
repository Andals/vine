<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http\Validator;

use Vine\Component\Http\Validator\Conf;
use Vine\Component\Http\Validator\Checker;


/**
 * Validate HTTP Params
 *
 * @author Liang Chao 
 */

class Validator 
{

    const TYPE_STR = 1;
    const TYPE_NUM = 2;
    const TYPE_ARR = 3;

    const ERROR_HANDING_EXCEPTION   = 1;
    const ERROR_HANDING_USE_DEFAULT = 2;
    const ERROR_HANDING_DISCARD     = 3;    

    public $conf;

    public function __construct() {
        $request = new \Vine\Component\Http\RequestFactory();
        $this->conf = new Conf($request->make());
    }
}
