<?php

namespace Vine\Test\TestCase\Http;


/**
* Class TestValidator
*/
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        
    }


    public function testHttpValidatorSetterDetector()
    {
        $request = new \Vine\Component\Http\RequestFactory();
        $validator = new \Vine\Component\Http\Validator\Validator($request->make());
        $name = 'app_id';
        $validator->conf->setParamType($name, \Vine\Component\Http\Validator\Validator::TYPE_NUM);
        $validator->conf->setParamDefaultValue($name, -1);
        $validator->conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\Checker', 'numNotZero'));
        $validator->conf->setParamErrorHanding($name, \Vine\Component\Http\Validator\Validator::ERROR_HANDING_EXCEPTION);
        $validator->conf->setParamErrorException($name, '\Exception', '1002', '应用Id不正确');

        $this->assertEquals(\Vine\Component\Http\Validator\Validator::TYPE_NUM, $validator->conf->getParamType($name));
        $this->assertEquals(-1, $validator->conf->getParamDefaultValue($name));
        $this->assertEquals(array('\Vine\Component\Http\Validator\Checker', 'numNotZero'), $validator->conf->getParamCheckFunc($name));
        $this->assertEquals(\Vine\Component\Http\Validator\Validator::ERROR_HANDING_EXCEPTION, $validator->conf->getParamErrorHanding($name));
        $this->assertEquals('\Exception', $validator->conf->getParamErrorExceptionClsname($name));
        $this->assertEquals('1002', $validator->conf->getParamErrorErrno($name));
        $this->assertEquals('应用Id不正确', $validator->conf->getParamErrorMsg($name));
    }

    public function testHttpValidatorParseRequestDetector()
    {
        $request = new \Vine\Component\Http\RequestFactory();
        $validator = new \Vine\Component\Http\Validator\Validator($request->make());
        $name = 'app_name';
        $validator->conf->setParamType($name, \Vine\Component\Http\Validator\Validator::TYPE_STR);
        $validator->conf->setParamDefaultValue($name, 'name');
        $validator->conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\Checker', 'strNotNull'));
        $validator->conf->setParamErrorHanding($name, \Vine\Component\Http\Validator\Validator::ERROR_HANDING_EXCEPTION);
        $validator->conf->setParamErrorException($name, '\Exception', '1003', '应用名称不正确');        

        $_GET = array(
            'appdesc' => 'framework',
            'app_name' => 'vine',
            
        );
        $validator->parseRequestParams();
        $this->assertEquals(array('app_name'=>'vine'), $validator->getRequestParams());
        $this->assertArrayHasKey('app_name', $validator->getRequestParams());
        $this->assertArrayNotHasKey('app_desc', $validator->getRequestParams());

    }
}
