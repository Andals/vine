<?php
namespace Vine\Test\TestCase\Validator;

/**
* Class TestValidator
*/
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testHttpValidatorSetterDetector()
    {
        $name = 'app_id';
        $validator = new \Vine\Component\Validator\Validator();
        $conf = $validator->getConf();
        $conf->setParamType($name, \Vine\Component\Validator\Validator::TYPE_NUM);
        $conf->setParamDefaultValue($name, -1);
        $conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\Checker', 'numNotZero'));
        $conf->setParamExceptionParams($name, 'app_id不正确', 1002);
        $this->assertEquals(\Vine\Component\Validator\Validator::TYPE_NUM, $conf->getParamType($name));
        $this->assertEquals(-1, $conf->getParamDefaultValue($name));
        $this->assertEquals(array('\Vine\Component\Http\Validator\Checker', 'numNotZero'), $conf->getParamCheckFunc($name));
    }

    public function testHttpValidatorParseRequestDetector()
    {
        $name = 'app_name';
        $requestFactory = new \Vine\Component\Http\RequestFactory();
        $request = $requestFactory->make();
        $validator = new \Vine\Component\Validator\Validator();
        $conf = $validator->getConf();

        $conf->setParamType($name, \Vine\Component\Validator\Validator::TYPE_STR);
        $conf->setParamDefaultValue($name, 'name');
        $conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\Checker', 'strNotNull'));
        $conf->setParamExceptionParams($name, 'app_name不正确', 1003);        

        $_GET = array(
            'appdesc' => 'framework',
            'app_name' => 'vine',
        );

        $originParams = $request->getParam();
        $validator->filterParams($originParams);
        $this->assertEquals(array('app_name'=>'vine'), $validator->getFilteredParams());
        $this->assertArrayHasKey('app_name', $validator->getFilteredParams());
        $this->assertArrayNotHasKey('app_desc', $validator->getFilteredParams());

        $originParams = array(
            'appdesc' => 'framework',
            'app_name' => 'vine-framework',            
        );
        $validator->filterParams($originParams);
        $this->assertEquals(array('app_name'=>'vine-framework'), $validator->getFilteredParams());        

    }
}
