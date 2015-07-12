<?php

/**
 * This file is part of the Vine Framework (http://vine.org)
 * Copyright (c) 2015 Liang Chao
 */

namespace Vine\Component\Http;


/**
* Rendering helpers for HTTP
* @author Liang Chao 
*/
class Helpers
{
    
    /**
     * @internal
     */
    public static function stripSlashes($arr, $onlyKeys = FALSE)
    {
        $res = array();
        foreach ($arr as $k => $v) {
            $res[stripslashes($k)] = is_array($v)
                ? self::stripSlashes($v, $onlyKeys)
                : ($onlyKeys ? $v : stripslashes($v));
        }
        return $res;
    }
}
