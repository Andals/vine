<?php
/**
* @file Processor.php
* @author ligang
* @date 2015-08-24
 */

namespace Vine\Component\Mysql\Entity;

/**
    * Process entity column
 */
class Processor
{/*{{{*/
    public static function processSimpleInt($value, $ext = null)
    {/*{{{*/
        if (!is_numeric($value)) {
            throw new \Exception("$value is not int");
        }

        return intval($value);
    }/*}}}*/
    public static function processSimpleString($value, $ext = null)
    {/*{{{*/
        if (!is_string($value)) {
            throw new \Exception("$value is not string");
        }

        if (isset($ext['max_len'])) {
            if (strlen($value) > $ext['max_len']) {
                throw new \Exception("$value exceed max_len");
            }
        }

        return trim($value);
    }/*}}}*/
    public static function processSimpleDate($value, $ext = null)
    {/*{{{*/
        if (false ===  strtotime($value)) {
            throw new \Exception("$value is not valid date format");
        }

        return $value;
    }/*}}}*/
}/*}}}*/
