<?php
namespace Vine\View;

/**
    * This is view base
 */
abstract class Base implements \Vine\Contract\View
{/*{{{*/

    /**
        * {@inheritdoc}
     */
	public function setViewRoot($view_root)
    {/*{{{*/
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
	public function assign($key, $value, $secure_filter=true)
    {/*{{{*/
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
	public function render($tpl_name, $data=array())
    {/*{{{*/
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
	public function display($tpl_name, $data=array())
    {/*{{{*/
    }/*}}}*/
}/*}}}*/
