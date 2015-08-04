<?php
namespace Vine\Test\TestCase\Mysql;

class TestDao extends \Vine\Component\Mysql\Dao\Base
{/*{{{*/
    public function setTableName($hash = null)
    {/*{{{*/
        $this->tableName = 'test';
    }/*}}}*/
}/*}}}*/

class DaoTest extends \PHPUnit_Framework_TestCase
{/*{{{*/
    private $driver = null;
    private $dao    = null;

    public function __construct()
    {/*{{{*/
        $formater = new \Vine\Component\Log\Formater\General('userMysqlDaoTest');
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

        $this->dao = new TestDao();

        $driver = new \Vine\Component\Mysql\Driver($dbConf, $logger);
        $this->dao->setDriver($driver)->setTableName();
    }/*}}}*/

    public function testDeleteById()
    {/*{{{*/
        $r1 = $this->dao->selectById(1001);
        $r2 = $this->dao->deleteById(1001);

        if (empty($r1)) {
            $this->assertEquals($r2, 0);
        } else {
            $this->assertEquals($r2, 1);
        }
    }/*}}}*/
    public function testInsert()
    {/*{{{*/
        $item = array(
            'id'   => 1001,
            'name' => 'vine',
        );

        $result = $this->dao->insert($item);

        $this->assertEquals($result, 1);
    }/*}}}*/
    public function testUpdateById()
    {/*{{{*/
        $result = $this->dao->updateById(1001, array('name' => 'vine-demo'));

        $this->assertEquals($result, 1);
    }/*}}}*/
    public function testSelectById()
    {/*{{{*/
        $result = $this->dao->selectById(1001);

        $this->assertEquals($result['id'], 1001);
        $this->assertEquals($result['name'], 'vine-demo');
    }/*}}}*/
    public function testSelectByIds()
    {/*{{{*/
        $result = $this->dao->selectByIds(array(1001));

        $this->assertEquals($result[0]['id'], 1001);
        $this->assertEquals($result[0]['name'], 'vine-demo');
    }/*}}}*/
}/*}}}*/
