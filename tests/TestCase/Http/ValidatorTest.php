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
        $validator = new \Vine\Component\Http\Validator;
        $name = 'app_id';
        $validator->conf->setParamType($name, \Vine\Component\Http\Validator::TYPE_NUM);
        $validator->conf->setParamDefaultValue($name, -1);
        $validator->conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\ValidatorCheck', 'numNotZero'));
        $validator->conf->setParamErrorHanding($name, \Vine\Component\Http\Validator::ERROR_HANDING_EXCEPTION);
        $validator->conf->setParamErrorException($name, '\Exception', '1002', '应用Id不正确');

        $this->assertEquals(\Vine\Component\Http\Validator::TYPE_NUM, $validator->conf->getParamType($name));
        $this->assertEquals(-1, $validator->conf->getParamDefaultValue($name));
        $this->assertEquals(array('\Vine\Component\Http\Validator\ValidatorCheck', 'numNotZero'), $validator->conf->getParamCheckFunc($name));
        $this->assertEquals(\Vine\Component\Http\Validator::ERROR_HANDING_EXCEPTION, $validator->conf->getParamErrorHanding($name));
        $this->assertEquals('\Exception', $validator->conf->getParamErrorExceptionClsname($name));
        $this->assertEquals('1002', $validator->conf->getParamErrorErrno($name));
        $this->assertEquals('应用Id不正确', $validator->conf->getParamErrorMsg($name));
    }

    public function testHttpValidatorParseRequestDetector()
    {
        $validator = new \Vine\Component\Http\Validator;
        $name = 'app_name';
        $validator->conf->setParamType($name, \Vine\Component\Http\Validator::TYPE_STR);
        $validator->conf->setParamDefaultValue($name, 'name');
        $validator->conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\ValidatorCheck', 'strNotNull'));
        $validator->conf->setParamErrorHanding($name, \Vine\Component\Http\Validator::ERROR_HANDING_EXCEPTION);
        $validator->conf->setParamErrorException($name, '\Exception', '1003', '应用名称不正确');        

        $_GET = array(
            'appdesc' => 'framework',
            'app_name' => 'vine',
            
        );
        $validator->conf->parseRequestParams();
        $this->assertEquals(array('app_name'=>'vine'), $validator->conf->getRequestParams());
        $this->assertArrayHasKey('app_name', $validator->conf->getRequestParams());
        $this->assertArrayNotHasKey('app_desc', $validator->conf->getRequestParams());

    }
}
