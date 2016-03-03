<?php
/**
* @file Task.php
* @brief Task container
* @author ligang
* @date 2016-02-24
 */

namespace Vine\Component\Container;

class Task extends General
{/*{{{*/

    //argv
    const KEY_TASK_ARGS   = 'task_args';

    //params
    const KEY_TASK_PARAMS = 'task_params';

    /**
        * Set task args
        *
        * @param array $args
        *
        * @return self
     */
    public function setTaskArgs($args)
    {/*{{{*/
        return $this->add(self::KEY_TASK_ARGS, $args);
    }/*}}}*/

    /**
        * Get task args
        *
        * @return array
     */
    public function getTaskArgs()
    {/*{{{*/
        return $this->get(self::KEY_TASK_ARGS);
    }/*}}}*/

    /**
        * Set task params
        *
        * @param array $params
        *
        * @return self
     */
    public function setTaskParams($params)
    {/*{{{*/
        return $this->add(self::KEY_TASK_PARAMS, $params);
    }/*}}}*/

    /**
        * Get task params
        *
        * @return array
     */
    public function getTaskParams()
    {/*{{{*/
        return $this->get(self::KEY_TASK_PARAMS);
    }/*}}}*/
}/*}}}*/
