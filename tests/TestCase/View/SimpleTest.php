<?php

namespace Vine\Test\TestCase\View;

class SimpleTest extends \PHPUnit_Framework_TestCase
{

    private $viewRoot = null;

    private $simpleView = null;

    public function setUp()
    {
        $this->viewRoot = dirname(__FILE__) . "/view/";
        $this->simpleView = new \Vine\Component\View\Simple();
        $this->simpleView->setViewRoot($this->viewRoot);
    }

    public function testSetViewRoot()
    {
        $this->assertEquals($this->viewRoot, $this->simpleView->getViewRoot());
    }

    public function testRender()
    {
        $this->assertEquals('test render', $this->simpleView->render('simple/render.php'));
    }

    /**
     * @expectedException \Exception
     */
    public function testRenderNotExistFile()
    {
        $this->simpleView->render('simple/not_exist_file.php');
    }

    /**
     * @expectedException \Exception
     */
    public function testAssignNameErrorVariable()
    {
        $this->simpleView->assign('0abc', 'value');
    }

    public function testAssignVariable()
    {
        $name = 'string value';
        
        // assign string value
        $this->simpleView->assign('name', $name, false);
        $this->assertEquals($name, $this->simpleView->render('simple/assign_string_value.php'));
        
        $userList = array(
            array(
                'id' => 1, 
                'name' => 'user1', 
                'age' => 21
            ), 
            array(
                'id' => 2, 
                'name' => 'user2', 
                'age' => 22
            ), 
            array(
                'id' => 3, 
                'name' => 'user3', 
                'age' => 23
            )
        );
        
        // assign array value
        $this->simpleView->assign('userList', $userList, false);
        $this->assertEquals(json_encode($userList), $this->simpleView->render('simple/assign_array_value.php'));
    }

    public function testAssignVariableWithFilter()
    {
        $name = 'string value<script>alert(1)</script>';
        
        // assign string value with filter
        $this->simpleView->assign('name', $name, true);
        $this->assertEquals(htmlspecialchars($name), $this->simpleView->render('simple/assign_string_value_with_filter.php'));
        
        // assign array value with filter
        $userList = array(
            array(
                'id' => 1, 
                'name' => 'user1<script>alert(1)</script>', 
                'is_vip' => true, 
                'pet_list' => array()
            ), 
            array(
                'id' => 2, 
                'name' => 'user2<script>alert(2)</script>', 
                'is_vip' => false, 
                'pet_list' => array(
                    array(
                        'name' => '<script>alert("cat")</script>'
                    )
                )
            )
        );
        
        $this->simpleView->assign('userList', $userList, true);
        $this->assertEquals(htmlspecialchars($userList[0]['name'] . $userList[1]['name'] . $userList[1]['pet_list'][0]['name']), $this->simpleView->render('simple/assign_array_value_with_filter.php'));
    }

    public function testRenderData()
    {
        $data = array(
            'name' => 'render data'
        );
        $this->assertEquals('hello render data', $this->simpleView->render('simple/render_data.php', $data));
    }

    public function testRenderInRender()
    {
        $name = 'string value';
        $this->simpleView->assign('name', $name);
        $this->assertEquals('render in render: ' . $name, $this->simpleView->render('simple/render_in_render.php'));
    }
}