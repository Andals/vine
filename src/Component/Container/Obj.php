<?php
/**
* @file Obj.php
* @author ligang
* @version 1.0
* @date 2015-07-03
 */

namespace Vine\Component\Container;

/**
    * Store obj use key => value
 */
class Obj implements \Vine\Component\Container\ContainerInterface
{/*{{{*/
    protected $objs = array();

    /**
        * {@inheritdoc}
     */
    public function add($obj, $key='')
    {/*{{{*/
        if(!is_object($obj))
        {
            return false;
        }

        if('' == $key)
        {
            $key = get_class($obj);
        }

        $this->objs[$key] = $obj;

        return true;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function get($key)
    {/*{{{*/
        return isset($this->objs[$key]) ? $this->objs[$key] : null;
    }/*}}}*/
}/*}}}*/
