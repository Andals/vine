<?php
/**
* @file Error.php
* @author ligang
* @version 1.0
* @date 2015-07-31
 */

namespace Vine\Component\Mysql;


/**
    * This class identify mysql error
 */
class Error
{/*{{{*/
    const DUPLICATE_ENTRY_CODE         = 23000;
    const FOREIGN_KEY_CONSTRAINT_FAILS = 'foreign key constraint fails';
    const LOCK_WAIT_TIMEOUT            = 'SQLSTATE[HY000]: General error: 1205 Lock wait timeout exceeded; try restarting transaction';
    const LOST_CONNECTION              = 'SQLSTATE[HY000]: General error: 2013 Lost connection to MySQL server during query';
    const GONE_AWAY                    = 'SQLSTATE[HY000]: General error: 2006 MySQL server has gone away';


    public static function duplicateEntry($e)
    {/*{{{*/
        return ($e->getCode() == self::DUPLICATE_ENTRY_CODE) ? true : false;
    }/*}}}*/
    public static function foreignKeyConstraintFails($e)
    {/*{{{*/
        return (strpos($e->getMessage(), self::FOREIGN_KEY_CONSTRAINT_FAILS) === false) ? false : true;
    }/*}}}*/
    public static function lostConnection($e)
    {/*{{{*/
        return ($e->getMessage() == self::LOST_CONNECTION) ? true : false;
    }/*}}}*/
    public static function lockWaitTimeout($e)
    {/*{{{*/
        return ($e->getMessage() == self::LOCK_WAIT_TIMEOUT) ? true : false;
    }/*}}}*/
    public static function goneAway($e)
    {/*{{{*/
        return ($e->getMessage() == self::GONE_AWAY) ? true : false;
    }/*}}}*/
}/*}}}*/
