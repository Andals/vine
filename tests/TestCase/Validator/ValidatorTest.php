<?php
namespace Vine\Test\TestCase\Validator;

use PHPUnit\Framework\TestCase;
use \Vine\Component\Validator\Validator;
use \Vine\Component\Http\RequestFactory;
use \Vine\Component\Validator\FullScanFilter;

/**
 * Class TestValidator
 */
class ValidatorTest extends TestCase
{
    public function testHttpValidatorSetterDetector()
    {
        $name      = 'app_id';
        $validator = new Validator();
        $conf      = $validator->getConf();
        $conf->setParamType($name, Validator::TYPE_NUM);
        $conf->setParamDefaultValue($name, -1);
        $conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\Checker', 'numNotZero'));
        $conf->setParamExceptionParams($name, 'app_id不正确', 1002);
        $this->assertEquals(Validator::TYPE_NUM, $conf->getParamType($name));
        $this->assertEquals(-1, $conf->getParamDefaultValue($name));
        $this->assertEquals(array('\Vine\Component\Http\Validator\Checker', 'numNotZero'), $conf->getParamCheckFunc($name));
    }

    public function testHttpValidatorParseRequestDetector()
    {
        $name           = 'app_name';
        $requestFactory = new RequestFactory();
        $request        = $requestFactory->make();
        $validator      = new Validator();
        $conf           = $validator->getConf();

        $conf->setParamType($name, Validator::TYPE_STR);
        $conf->setParamDefaultValue($name, 'name');
        $conf->setParamCheckFunc($name, array('\Vine\Component\Http\Validator\Checker', 'strNotNull'), array("maxLen" => 12, "minLen" => 5));
        $conf->setParamExceptionParams($name, 'app_name不正确', 1003);

        $_GET = array(
            'appdesc' => 'framework',
            'app_name' => 'vine',
        );

        $originParams = $request->getParam();
        $validator->filterParams($originParams);
        $this->assertEquals(array('app_name' => 'vine'), $validator->getFilterParams());
        $this->assertArrayHasKey('app_name', $validator->getFilterParams());
        $this->assertArrayNotHasKey('app_desc', $validator->getFilterParams());

        $originParams = array(
            'appdesc' => 'framework',
            'app_name' => 'vine-framework',
        );
        $validator->filterParams($originParams);
        $this->assertEquals(array('app_name' => 'vine-framework'), $validator->getFilterParams());

    }

    public function testFullScanFilter()
    {
        $validator = new Validator();
        $conf      = $validator->getConf();
        $conf->setParamsFilter(new FullScanFilter());

        $name = 'id';
        $conf->setParamType($name, Validator::TYPE_NUM);
        $conf->setParamDefaultValue($name, -1);
        $conf->setParamCheckFunc($name, array('\Vine\Component\Validator\Checker', 'numNotZero'));

        $name = 'url';
        $conf->setParamType($name, Validator::TYPE_STR);
        $conf->setParamDefaultValue($name, '');
        $conf->setParamCheckFunc($name, array('\Vine\Component\Validator\Checker', 'strNotNull'));

        $originParams = array(
            'id' => 10,
            'url' => 'www.vine.com',
        );

        $result = $validator->filterParams($originParams);
        $this->assertEquals(true, $result['valid']);

        $originParams = array(
            'id' => 0,
            'url' => 'www.vine.com',
        );
        $result       = $validator->filterParams($originParams);
        $this->assertEquals(false, $result['valid']);
        $this->assertEquals(true, isset($result['errors']['id']));
    }
}
