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
        $factory = new \Vine\Component\Http\RequestFactory;
        $request = $factory->createHttpRequest();        
        $response = new \Vine\Component\Http\Response($request);
        $response->setBody('Hello World');
        $this->assertEquals('Hello World', $response->getBody());
    }

    public function testHTTPResponseBodyWithResponseDetector()
    {
        $factory = new \Vine\Component\Http\RequestFactory;
        $request = $factory->createHttpRequest();   

        $response1 = new \Vine\Component\Http\Response($request);
        $response1->setBody('Hello World');

        $response2 = new \Vine\Component\Http\Response($request);
        $response2->setBody($response1);

        $this->assertEquals('Hello World', $response2->getBody());
    }

    public function testHTTPResponseContentTypeDetector()
    {
        $factory = new \Vine\Component\Http\RequestFactory;
        $request = $factory->createHttpRequest();   

        $response = new \Vine\Component\Http\Response($request);
        $this->assertEquals('text/html', $response->getContentType());

        $response->setContentType('application/json');
        $this->assertEquals('application/json', $response->getContentType());       
    }

    public function testHTTPResponseContentTypeWithCharsetDetector()
    {
        $factory = new \Vine\Component\Http\RequestFactory;
        $request = $factory->createHttpRequest();   

        $response = new \Vine\Component\Http\Response($request);
        $response->setContentType('application/json', 'iso-8859-1');
        $this->assertEquals('application/json', $response->getContentType());
        $this->assertEquals('iso-8859-1', $response->getCharset());
    }

    public function testHTTPResponseStatusDetector()
    {
        $factory = new \Vine\Component\Http\RequestFactory;
        $request = $factory->createHttpRequest();   

        $response = new \Vine\Component\Http\Response($request);
        $this->assertEquals(200, $response->getStatus());

        $response->setStatus(404);
        $this->assertEquals(404, $response->getStatus());

        $response->setStatus(999); // invalid
        $this->assertEquals(404, $response->getStatus());        
    }

    public function testHTTPResponseJsonDetector()
    {
        $factory = new \Vine\Component\Http\RequestFactory;
        $request = $factory->createHttpRequest();   

        $response = new \Vine\Component\Http\Response($request);
        $response->setBody($response->json(array('name'=>'liangchao')));
        $this->assertEquals('{"name":"liangchao"}', $response->send());        

        $response = new \Vine\Component\Http\Response($request);
        $response->setBody($response->jsonP(array('name'=>'liangchao')));
        $this->assertEquals('/**/_callback({"name":"liangchao"});', $response->send());            
    }


}
