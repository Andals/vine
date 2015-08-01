<?php

namespace Vine\Test\TestCase\Http;

use Vine\Component\Http\JsonResponse;
use Vine\Component\Http\ResponseFactory;
/**
* Class TestResponse
*/
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        
    }

    public function testHttpResponseBody()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContent('Hello World');
        $this->assertEquals('Hello World', $response->getContent());
    }

    public function testHttpResponseBodyWithResponse()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContent('Hello World');
    }

    public function testHttpResponseContentType()
    {

        $response = new \Vine\Component\Http\Response();
        $this->assertEquals('text/html', $response->getContentType());
        $response->setContentType('application/json');
        $this->assertEquals('application/json', $response->getContentType());       
    }

    public function testHttpResponseContentTypeWithCharset()
    {
        $response = new \Vine\Component\Http\Response();
        $response->setContentType('application/json', 'iso-8859-1');
        $this->assertEquals('application/json', $response->getContentType());
        $this->assertEquals('iso-8859-1', $response->getCharset());
    }

    public function testHttpResponseStatus()
    {

        $response = new \Vine\Component\Http\Response();
        $this->assertEquals(200, $response->getStatus());

        $response->setStatus(404);
        $this->assertEquals(404, $response->getStatus());

        $response->setStatus(999); // invalid
        $this->assertEquals(404, $response->getStatus());        
    }

    public function testHttpResponseRedirect()
    {
        // $redirectResponse = new \Vine\Component\Http\RedirectResponse('http://www.baidu.com');
        $redirectResponse = \Vine\Component\Http\RedirectResponse::create('http://www.baidu.com');
        $this->assertEquals(302, $redirectResponse->getStatus());
        $this->assertEquals('http://www.baidu.com', $redirectResponse->getTargetUrl());
    }

    public function testHttpResponseJsonP()
    {
        $response = new JsonResponse();
        $this->assertSame('[]', $response->getContent());
    }

    public function testHttpResponseJsonWithArray()
    {
        $response = new JsonResponse(array(0, 1, 2, 3));
        $this->assertSame('[0,1,2,3]', $response->getContent());
    }

    public function testHttpResponseJsonWithAssocArray()
    {
        $response = new JsonResponse(array('foo' => 'bar'));
        $this->assertSame('{"foo":"bar"}', $response->getContent());
    }    

    public function testHttpResponseJsonWithSimpleTypes()
    {
        $response = new JsonResponse('foo');
        $this->assertSame('"foo"', $response->getContent());

        $response = new JsonResponse(0);
        $this->assertSame('0', $response->getContent());

        $response = new JsonResponse(true);
        $this->assertSame('true', $response->getContent());        
    }

    public function testHttpResponseJsonWithCustomStatus()
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

    public function testHttpResponseJsonPCallback()
    {
        $response = new JsonResponse(array('foo' => 'bar'));
        $response->setCallback('_callback');
        $this->assertEquals('/**/_callback({"foo":"bar"});', $response->getContent());
    }

    public function testHttpResponseFactory()
    {
        $responseFactory = new ResponseFactory();
        $response = $responseFactory->make(123);
        $this->assertEquals('123', $response->getContent());

        $responseFactory = new ResponseFactory();
        $response = $responseFactory->json(array('foo' => 'bar'));
        $this->assertEquals('{"foo":"bar"}', $response->getContent());

        $responseFactory = new ResponseFactory();
        $response = $responseFactory->jsonp('_callback', array('foo' => 'bar'));
        $this->assertEquals('/**/_callback({"foo":"bar"});', $response->getContent());

        $responseFactory = new ResponseFactory();
        $response = $responseFactory->redirect('http://www.baidu.com');
        $this->assertEquals('http://www.baidu.com', $response->getTargetUrl());
    }

}
