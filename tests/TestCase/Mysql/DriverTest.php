<?php
namespace Vine\Test\TestCase\Mysql;

class DriverTest extends \PHPUnit_Framework_TestCase
{/*{{{*/
    private $driver    = null;
    private $tableName = 'test';

    public function __construct()
    {/*{{{*/
        $formater = new \Vine\Component\Log\Formater\General('userMysqlDriverTest');
        $writer   = new \Vine\Component\Log\Writer\File('/tmp/test.log');
        $logger   = new \Vine\Component\Log\Logger($formater, $writer, \Psr\Log\LogLevel::DEBUG);

        $dbConf = array(
            'host'       => '127.0.0.1',
            'user'       => 'root',
            'pass'       => '123',
            'name'       => 'test',
            'port'       => 3306,
            'persistent' => false,
            'charset'    => 'UTF8',
        );

        $this->driver = new \Vine\Component\Mysql\Driver($dbConf, $logger);
    }/*}}}*/

    public function testExec()
    {/*{{{*/
        $sql    = "insert into $this->tableName (name) values (?)";
        $values = array('a');

        $r = $this->driver->execute($sql, $values);

        $this->assertEquals($r, 1);
    }/*}}}*/
    public function testQuery()
    {/*{{{*/
        $sql  = "select * from $this->tableName";
        $rows = $this->driver->query($sql);

        $sql = "select count(*) as cnt from $this->tableName";
        $r   = $this->driver->query($sql);

        $this->assertEquals($r[0]['cnt'], count($rows));
    }/*}}}*/
}/*}}}*/
