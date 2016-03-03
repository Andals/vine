<?php
/**
* @file Base.php
* @brief Base container
* @author ligang
* @date 2016-02-24
 */

namespace Vine\Component\Container;

/**
    * Store mixed value use key => value
 */
class Base implements ContainerInterface
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
