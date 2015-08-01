<?php

namespace Vine\Test\TestCase\HTTP;


/**
* Class TestResponse
*/
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        
    }

    public function testHTTPResponseBodyDetector()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContent('Hello World');
        $this->assertEquals('Hello World', $response->getContent());
    }

    public function testHTTPResponseBodyWithResponseDetector()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContent('Hello World');
    }

    public function testHTTPResponseContentTypeDetector()
    {

        $response = new \Vine\Component\Http\Response();
        $this->assertEquals('text/html', $response->getContentType());
        $response->setContentType('application/json');
        $this->assertEquals('application/json', $response->getContentType());       
    }

    public function testHTTPResponseContentTypeWithCharsetDetector()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContentType('application/json', 'iso-8859-1');
        $this->assertEquals('application/json', $response->getContentType());
        $this->assertEquals('iso-8859-1', $response->getCharset());
    }

    public function testHTTPResponseStatusDetector()
    {

        $response = new \Vine\Component\Http\Response();
        $this->assertEquals(200, $response->getStatus());

        $response->setStatus(404);
        $this->assertEquals(404, $response->getStatus());

        $response->setStatus(999); // invalid
        $this->assertEquals(404, $response->getStatus());        
    }

    public function testHTTPResponseRedirectDetector()
    {
        // $redirectResponse = new \Vine\Component\Http\RedirectResponse('http://www.baidu.com');
        $redirectResponse = \Vine\Component\Http\RedirectResponse::create('http://www.baidu.com');
        $this->assertEquals(302, $redirectResponse->getStatus());
        $this->assertEquals('http://www.baidu.com', $redirectResponse->getTargetUrl());
    }

    public function testHTTPResponseJsonDetector()
    {
        // $factory = new \Vine\Component\Http\RequestFactory;
        // $request = $factory->createHttpRequest();   

        // $response = new \Vine\Component\Http\Response($request);
        // $response->setBody($response->json(array('name'=>'liangchao')));
        // $this->assertEquals('{"name":"liangchao"}', $response->send());        

        // $response = new \Vine\Component\Http\Response($request);
        // $response->setBody($response->jsonP(array('name'=>'liangchao')));
        // $this->assertEquals('/**/_callback({"name":"liangchao"});', $response->send());            
    }


}
