<?php
namespace Vine\Test\TestCase\Mysql;

class Test extends \Vine\Component\Mysql\Entity\Base
{/*{{{*/
    protected function initColumns()
    {/*{{{*/
        $this->addColumn('id', 0, array('\Vine\Component\Mysql\Entity\Processor', 'processSimpleInt'));
        $this->addColumn('name', '', array('\Vine\Component\Mysql\Entity\Processor', 'processSimpleString'), array('max_len' => 20));
    }/*}}}*/
}/*}}}*/

class EntityTest extends \PHPUnit_Framework_TestCase
{/*{{{*/
    public function testToItem()
    {/*{{{*/
        $item = array(
            'id'   => 1001,
            'name' => 'vine',
            'link' => 'http://vine.com',
        );

        $test = new Test();
        $test->setColumnsValues($item);
        $item = $test->toItem();

        $this->assertEquals($item['id'], 1001);
        $this->assertEquals($item['name'], 'vine');
        $this->assertEquals(isset($item['link']), false);
    }/*}}}*/
}/*}}}*/
