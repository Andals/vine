<?php
/**
* @file Obj.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Component\Container;

/**
    * Store mixed value use key => value
 */
class General implements ContainerInterface
{/*{{{*/
    protected $data = array();

    /**
        * {@inheritdoc}
     */
    public function add($key, $value)
    {/*{{{*/
        $this->data[$key] = $value;

        return $this;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function get($key)
    {/*{{{*/
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function have($key)
    {/*{{{*/
        return isset($this->data[$key]) ? true : false;
    }/*}}}*/
}/*}}}*/
