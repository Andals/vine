<?php

namespace Vine\Test\TestCase\HTTP;

use Vine\Component\Http\JsonResponse;

/**
* Class TestResponse
*/
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        
    }

    public function testHTTPResponseBody()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContent('Hello World');
        $this->assertEquals('Hello World', $response->getContent());
    }

    public function testHTTPResponseBodyWithResponse()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContent('Hello World');
    }

    public function testHTTPResponseContentType()
    {

        $response = new \Vine\Component\Http\Response();
        $this->assertEquals('text/html', $response->getContentType());
        $response->setContentType('application/json');
        $this->assertEquals('application/json', $response->getContentType());       
    }

    public function testHTTPResponseContentTypeWithCharset()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContentType('application/json', 'iso-8859-1');
        $this->assertEquals('application/json', $response->getContentType());
        $this->assertEquals('iso-8859-1', $response->getCharset());
    }

    public function testHTTPResponseStatus()
    {

        $response = new \Vine\Component\Http\Response();
        $this->assertEquals(200, $response->getStatus());

        $response->setStatus(404);
        $this->assertEquals(404, $response->getStatus());

        $response->setStatus(999); // invalid
        $this->assertEquals(404, $response->getStatus());        
    }

    public function testHTTPResponseRedirect()
    {
        // $redirectResponse = new \Vine\Component\Http\RedirectResponse('http://www.baidu.com');
        $redirectResponse = \Vine\Component\Http\RedirectResponse::create('http://www.baidu.com');
        $this->assertEquals(302, $redirectResponse->getStatus());
        $this->assertEquals('http://www.baidu.com', $redirectResponse->getTargetUrl());
    }

    public function testHTTPResponseJson()
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

    public function testHTTPResponseJsonP()
    {
        $response = new JsonResponse();
        $this->assertSame('[]', $response->getContent());
    }

    public function testHTTPResponseJsonWithArray()
    {
        $response = new JsonResponse(array(0, 1, 2, 3));
        $this->assertSame('[0,1,2,3]', $response->getContent());
    }

    public function testHTTPResponseJsonWithAssocArray()
    {
        $response = new JsonResponse(array('foo' => 'bar'));
        $this->assertSame('{"foo":"bar"}', $response->getContent());
    }    

    public function testHTTPResponseJsonWithSimpleTypes()
    {
        $response = new JsonResponse('foo');
        $this->assertSame('"foo"', $response->getContent());

        $response = new JsonResponse(0);
        $this->assertSame('0', $response->getContent());

        $response = new JsonResponse(true);
        $this->assertSame('true', $response->getContent());        
    }

    public function testHTTPResponseJsonWithCustomStatus()
    {
        $response = new JsonResponse(true, 202);
        $this->assertSame(202, $response->getStatus());
    }

    public function testConstructorAddsContentTypeHeader()
    {
        $response = new JsonResponse();
        $this->assertSame('application/json', $response->getContentType());
    }    

    public function testConstructorWithCustomContentType()
    {
        $response = new JsonResponse(array(), 200);
        $response->setContentType('application/vnd.acme.blog-v1+json');
        $this->assertSame('application/vnd.acme.blog-v1+json', $response->getContentType());
    }


}
