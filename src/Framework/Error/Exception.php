<?php
/**
* @file Exception.php
* @brief exception
* @author ligang
* @version 1.0
* @date 2015-07-05
 */

namespace Vine\Framework\Error;

/**
    * This class define exception
 */
class Exception extends \Exception
{/*{{{*/
	protected $ext = null;

    public function __construct($errno, $msg = '', $ext = null)
    {/*{{{*/
        parent::__construct($msg, $errno);

		$this->ext = $ext;
    }/*}}}*/

    /**
        * Get ext data
        *
        * @return any depend on your saved
     */
	public function getExt()
	{/*{{{*/
		return $this->ext;
	}/*}}}*/
}/*}}}*/
