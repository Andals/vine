<?php
/**
* @file Errno.php
* @brief errno
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Error;

/**
    * This class define errno
 */
class Errno
{/*{{{*/
    const SUCCESS = 0;

    const E_COMMON_CLS_NOT_EXISTS   = 11;
    const E_COMMON_INVALID_INSTANCE = 12;

    const E_CONTROLLER_CONTROLLER_NOT_EXISTS = 101;
    const E_CONTROLLER_ACTION_NOT_EXISTS     = 102;


    const E_TASK_INVALID_ARGS     = 901;
    const E_TASK_INVALID_CMD      = 902;
    const E_TASK_INVALID_TASK_KEY = 903;
    const E_TASK_INVALID_TASK_CLS = 904;
}/*}}}*/
