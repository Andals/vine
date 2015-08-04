<?php
/**
* @file General.php
* @author ligang
* @version 1.0
* @date 2015-08-04
 */

namespace Vine\Component\Log\Formater;

/**
    * Interpolate message usage context
 */
class General implements FormaterInterface
{/*{{{*/
    const DEF_COL_SPR     = "\t";
    const DEF_PLACEHOLDER = '-';

    private $logId = '';

    public function __construct($logId = self::DEF_PLACEHOLDER)
    {/*{{{*/
        $this->logId = $logId;
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function fmt($level, $message, array $context = array())
    {/*{{{*/
        if (!empty($context)) {
            $message = $this->interpolate($message, $context);
        }

        return $this->getLineHeader().self::DEF_COL_SPR.$level.self::DEF_COL_SPR.$message."\n";
    }/*}}}*/


    private function interpolate($message, $context)
    {/*{{{*/
        $replace = array();
        foreach ($context as $key => $value) {
            $replace['{' . $key . '}'] = $value;
        }

        return strtr($message, $replace);
    }/*}}}*/
    private function getLineHeader()
    {/*{{{*/
        $now = '['.date('Y-m-d H:i:s').']';
        $ip  = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : self::DEF_PLACEHOLDER;

        return $now.self::DEF_COL_SPR.$ip.self::DEF_COL_SPR.$this->logId;
    }/*}}}*/
}/*}}}*/
