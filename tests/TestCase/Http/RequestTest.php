<?php

namespace Vine\Test\TestCase\Http;


/**
* Class TestRequest
*/
class RequestTest extends \PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        
    }


    public function testHttpMethodDetector()
    {
        $_SERVER = array(
            'REQUEST_METHOD' => 'GET'
        );

        $factory = new \Vine\Component\Http\RequestFactory;
        $httpRequest = $factory->make();

        $this->assertEquals('GET', $httpRequest->getMethod());
        $this->assertTrue($httpRequest->isMethod('GET'));
    }

    /**
     * Tests HttpRequest $url object's properties
     */
    public function testHttpUrlDetector()
    {
        // Setup environment
        $_SERVER = array(
            'HTTPS' => 'On',
            'HTTP_HOST' => 'vine.org:8080',
            'QUERY_STRING' => 'x param=val.&pa%%72am=val2&param3=v%20a%26l%3Du%2Be',
            'REMOTE_ADDR' => '192.168.188.66',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/file.php?x param=val.&pa%%72am=val2&quotes\\"=\\"&param3=v%20a%26l%3Du%2Be',
            'SCRIPT_NAME' => '/file.php',
        );

        $factory = new \Vine\Component\Http\RequestFactory;
        $httpRequest = $factory->make();        

        $this->assertEquals('https', $httpRequest->getUrl()->getScheme());
        $this->assertEquals('', $httpRequest->getUrl()->getUser());
        $this->assertEquals('', $httpRequest->getUrl()->getPassword());
        $this->assertEquals('vine.org', $httpRequest->getUrl()->getHost());
        $this->assertEquals('8080', $httpRequest->getUrl()->getPort());
        $this->assertEquals('/file.php', $httpRequest->getUrl()->getPath());
        $this->assertEquals('x_param=val.&pa%25ram=val2&quotes%5C%22=%5C%22&param3=v+a%26l%3Du%2Be', $httpRequest->getUrl()->getQuery());
        $this->assertEquals('', $httpRequest->getUrl()->getFragment());
        $this->assertEquals('vine.org:8080', $httpRequest->getUrl()->getAuthority());
        $this->assertEquals('https://vine.org:8080', $httpRequest->getUrl()->getHostUrl());
        $this->assertEquals('https://vine.org:8080/', $httpRequest->getUrl()->getBaseUrl());
        $this->assertEquals('file.php?x_param=val.&pa%25ram=val2&quotes%5C%22=%5C%22&param3=v+a%26l%3Du%2Be', $httpRequest->getUrl()->getRelativeUrl());
        $this->assertEquals('https://vine.org:8080/file.php?x_param=val.&pa%25ram=val2&quotes%5C%22=%5C%22&param3=v+a%26l%3Du%2Be', $httpRequest->getUrl()->getAbsoluteUrl());
        $this->assertEquals('file.php', $httpRequest->getUrl()->getPathInfo());
    }

    public function testHttpRequestDetector()
    {
        // Setup environment
        $_SERVER = array(
            'HTTPS' => 'On',
            'HTTP_HOST' => 'vine.org:8080',
            'QUERY_STRING' => 'x param=val.&pa%%72am=val2&param3=v%20a%26l%3Du%2Be',
            'REMOTE_ADDR' => '192.168.188.66',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/file.php?x param=val.&pa%%72am=val2&quotes\\"=\\"&param3=v%20a%26l%3Du%2Be',
            'SCRIPT_NAME' => '/file.php',
        );

        $factory = new \Vine\Component\Http\RequestFactory;
        $httpRequest = $factory->make();        

        $this->assertEquals('GET', $httpRequest->getMethod());
        $this->assertTrue($httpRequest->isSecured());      
        $this->assertEquals('192.168.188.66', $httpRequest->getRemoteAddress());           
        $this->assertEquals('val.', $httpRequest->getQuery('x_param'));
        // $this->assertEquals('val.', $httpRequest->getParam('x_param'));
    }

    public function testHttpRequestHeaderDetector()
    {
        $httpRequest = new \Vine\Component\Http\Request(new \Vine\Component\Http\UrlScript, NULL, array());
        $this->assertEquals(array(), $httpRequest->getHeaders());

        $httpRequest = new \Vine\Component\Http\Request(new \Vine\Component\Http\UrlScript, NULL, array(
            'one' => '1',
            'TWO' => '2',
            'X-Header' => 'X',
        ));
        $this->assertEquals(array(
            'one' => '1',
            'two' => '2',
            'x-header' => 'X',
        ), $httpRequest->getHeaders());
        $this->assertEquals('1', $httpRequest->getHeader('One'));
        $this->assertEquals('2', $httpRequest->getHeader('Two'));
        $this->assertEquals('X', $httpRequest->getHeader('X-Header'));
    }

    public function testHttpRequestRawBodyDetector()
    {
        $httpRequest = new \Vine\Component\Http\Request(new \Vine\Component\Http\UrlScript, NULL, NULL, NULL, NULL, NULL, 'raw_body');
        $this->assertEquals('raw_body', $httpRequest->getRawBody());
    }
}
