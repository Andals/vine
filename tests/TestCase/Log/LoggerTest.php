<?php
namespace Vine\Test\TestCase\Log;

class LogTest extends \PHPUnit_Framework_TestCase
{/*{{{*/
    public function testLogger()
    {/*{{{*/
        $filePath = '/tmp/test.log';
        unlink($filePath);

        $formater = new \Vine\Component\Log\Formater\General('logTest');
        $writer   = new \Vine\Component\Log\Writer\File($filePath, \Vine\Component\Log\Writer\File::SPLIT_NO);
        $logger   = new \Vine\Component\Log\Logger($formater, $writer, \Psr\Log\LogLevel::WARNING);

        $logger->debug('debug');
        $logger->info('info');
        $logger->notice('notice');
        $logger->warning('warning');
        $logger->error('error');
        $logger->critical('critical');
        $logger->alert('alert');
        $logger->emergency('emergency');

        $contents = file_get_contents($filePath);
        $rows     = explode("\n", $contents);

        $validMessages = array('warning', 'error', 'critical', 'alert', 'emergency');
        $i = 0;
        while ($i < 5) {
            $row = trim($rows[$i]);
            if ($row == '') {
                continue;
            }

            $item = explode("\t", $row);
            $this->assertEquals($item[4], array_shift($validMessages));
            $i++;
        }
    }/*}}}*/
}/*}}}*/
