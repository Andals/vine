<?php
/**
* @file Knowledge.php
* @author ligang
* @version 1.0
* @date 2015-07-27
 */

namespace Vine\Component\Mysql;

class Knowledge
{/*{{{*/
    const DUPLICATE_ENTRY_CODE         = 23000;
    const FOREIGN_KEY_CONSTRAINT_FAILS = 'foreign key constraint fails';
    const LOCK_WAIT_TIMEOUT            = 'SQLSTATE[HY000]: General error: 1205 Lock wait timeout exceeded; try restarting transaction';
    const LOST_CONNECTION              = 'SQLSTATE[HY000]: General error: 2013 Lost connection to MySQL server during query';
    const GONE_AWAY                    = 'SQLSTATE[HY000]: General error: 2006 MySQL server has gone away';

    public static function duplicateEntry($e)
    {/*{{{*/
        return (self::DUPLICATE_ENTRY_CODE == $e->getCode()) ? true : false;
    }/*}}}*/
    public static function foreignKeyConstraintFails($e)
    {/*{{{*/
        return (false === strpos($e->getMessage(), self::FOREIGN_KEY_CONSTRAINT_FAILS)) ? false : true;
    }/*}}}*/
    public static function lostConnection($e)
    {/*{{{*/
        return (self::LOST_CONNECTION == $e->getMessage()) ? true : false;
    }/*}}}*/
    public static function lockWaitTimeout($e)
    {/*{{{*/
        return (self::LOCK_WAIT_TIMEOUT == $e->getMessage()) ? true : false;
    }/*}}}*/
    public static function goneAway($e)
    {/*{{{*/
        return (self::GONE_AWAY == $e->getMessage()) ? true : false;
    }/*}}}*/
}/*}}}*/
