<?php
namespace Vine\Test\TestCase\Validator;

/**
* Class TestValidator
*/
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testHttpValidatorSetterDetector()
    {
        $request = new \Vine\Component\Http\RequestFactory();
        $validator = new \Vine\Component\Validator\Validator($request->make());
        $name = 'app_id';
        $validator->conf->setParamType($name, \Vine\Component\Validator\Validator::TYPE_NUM);
        $validator->conf->setParamDefaultValue($name, -1);
        $validator->conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\Checker', 'numNotZero'));
        $validator->conf->setParamExceptionParams($name, 'app_id不正确', 1002);
        $this->assertEquals(\Vine\Component\Validator\Validator::TYPE_NUM, $validator->conf->getParamType($name));
        $this->assertEquals(-1, $validator->conf->getParamDefaultValue($name));
        $this->assertEquals(array('\Vine\Component\Http\Validator\Checker', 'numNotZero'), $validator->conf->getParamCheckFunc($name));

    }

    public function testHttpValidatorParseRequestDetector()
    {
        $request = new \Vine\Component\Http\RequestFactory();
        $validator = new \Vine\Component\Validator\Validator($request->make());
        $name = 'app_name';
        $validator->conf->setParamType($name, \Vine\Component\Validator\Validator::TYPE_STR);
        $validator->conf->setParamDefaultValue($name, 'name');
        $validator->conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\Checker', 'strNotNull'));
        $validator->conf->setParamExceptionParams($name, 'app_name不正确', 1003);        

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
