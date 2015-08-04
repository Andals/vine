<?php
/**
 * @file Logger.php
 * @author ligang
 * @version 1.0
 * @date 2015-08-04
 */

namespace Vine\Component\Log;

use \Psr\Log\LogLevel;

/**
 * Vine logger
 */
class Logger extends \Psr\Log\AbstractLogger
{/*{{{*/
    private $levelConf = array
    (/*{{{*/
        LogLevel::DEBUG => array
        (/*{{{*/
            'value'    => 100,
            'formater' => null,
            'writer'   => null,
        ),/*}}}*/
        LogLevel::INFO => array
        (/*{{{*/
            'value'    => 200,
            'formater' => null,
            'writer'   => null,
        ),/*}}}*/
        LogLevel::NOTICE => array
        (/*{{{*/
            'value'    => 300,
            'formater' => null,
            'writer'   => null,
        ),/*}}}*/
        LogLevel::WARNING => array
        (/*{{{*/
            'value'    => 400,
            'formater' => null,
            'writer'   => null,
        ),/*}}}*/
        LogLevel::ERROR => array
        (/*{{{*/
            'value'    => 500,
            'formater' => null,
            'writer'   => null,
        ),/*}}}*/
        LogLevel::CRITICAL => array
        (/*{{{*/
            'value'    => 600,
            'formater' => null,
            'writer'   => null,
        ),/*}}}*/
        LogLevel::ALERT => array
        (/*{{{*/
            'value'    => 700,
            'formater' => null,
            'writer'   => null,
        ),/*}}}*/
        LogLevel::EMERGENCY => array
        (/*{{{*/
            'value'    => 800,
            'formater' => null,
            'writer'   => null,
        ),/*}}}*/
    );/*}}}*/


    public function __construct(Formater\FormaterInterface $formater, Writer\WriterInterface $writer, $globalLevel)
    {/*{{{*/
        $this->setLevelConf($formater, $writer, $globalLevel);
    }/*}}}*/

    /**
        * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {/*{{{*/
        $this->checkLogLevel($level);

        $formater = $this->levelConf[$level]['formater'];
        $writer   = $this->levelConf[$level]['writer'];

        $writer->write($formater->fmt($level, $message, $context));
    }/*}}}*/



    private function setLevelConf($formater, $writer, $globalLevel)
    {/*{{{*/
        $this->checkLogLevel($globalLevel);

        $noopFormater     = new Formater\Noop();
        $noopWriter       = new Writer\Noop();
        $globalLevelValue = $this->levelConf[$globalLevel]['value'];
        foreach ($this->levelConf as $level => $conf) {
            if ($conf['value'] < $globalLevelValue) {
                $this->levelConf[$level]['formater'] = $noopFormater;
                $this->levelConf[$level]['writer']   = $noopWriter;
            } else {
                $this->levelConf[$level]['formater'] = $formater;
                $this->levelConf[$level]['writer']   = $writer;
            }
        }
    }/*}}}*/

    private function checkLogLevel($level)
    {/*{{{*/
        if (!isset($this->levelConf[$level])) {
            throw new \Exception('LogLevel must be in \Psr\Log\LogLevel');
        }
    }/*}}}*/
}/*}}}*/
