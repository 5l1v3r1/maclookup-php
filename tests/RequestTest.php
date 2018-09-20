<?php

use CodeLine\MacLookup\Clients\GuzzleClient;
use CodeLine\MacLookup\Exceptions\AccessDeniedException;
use CodeLine\MacLookup\Exceptions\AuthorizationRequiredException;
use CodeLine\MacLookup\Exceptions\InvalidMacOrOUIException;
use CodeLine\MacLookup\Exceptions\NotEnoughCreditsException;
use CodeLine\MacLookup\Exceptions\ServerErrorException;
use CodeLine\MacLookup\Exceptions\UnknownOutputFormatException;
use PHPUnit\Framework\Error\Deprecated;
use PHPUnit\Framework\TestCase;


/**
 * Class RequestTest
 */
class RequestTest extends TestCase
{
    /**
     * @var string
     */
    protected $sampleJson = <<<EOT
{
	"vendorDetails": {
		"oui": "08EA40",
		"isPrivate": false,
		"companyName": "Shenzhen Bilian Electronic Co，Ltd",
		"companyAddress": "NO.268， Fuqian Rd, Jutang community, Guanlan Town, Longhua New district shenzhen  guangdong  518000 CN",
		"countryCode": "CN"
	},
	"blockDetails": {
		"blockFound": true,
		"borderLeft": "08EA400000000000",
		"borderRight": "08EA40FFFFFFFFFF",
		"blockSize": 1099511627776,
		"assignmentBlockSize": "MA-L",
		"dateCreated": "",
		"dateUpdated": ""
	},
	"macAddressDetails": {
		"searchTerm": "08EA4026E5DE",
		"isValid": true,
		"transmissionType": "multicast",
		"administrationType": "LAA"
	}
}
EOT;

    /**
     *
     */
    public function testRequest200Code()
    {
        $stream = $this->getMockBuilder(\GuzzleHttp\Psr7\Stream::class)
            ->disableOriginalConstructor()
            ->setMethods(['close', '__toString'])
            ->getMock();

        $stream->method('close')
            ->willReturn('');
        $stream->method('__toString')
            ->willReturn($this->sampleJson);

        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getReasonPhrase')
            ->willReturn('OK');
        $response->method('getBody')
            ->willReturn($stream);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->assertEquals(
            $this->sampleJson,
            $client->request('https://test.test', 'get', [], [])
        );
    }

    /**
     *
     */
    public function testRequestWarningHeader()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getReasonPhrase')
            ->willReturn('OK');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->with($this->equalTo('Warning'))
            ->willReturn(true);
        $response->method('getHeader')
            ->with($this->equalTo('Warning'))
            ->willReturn('299 Warning: deprecated API version');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->setUseErrorHandler(true);
        $this->expectException(Deprecated::class);

        $this->assertEquals(
            $this->sampleJson,
            $client->request('https://test.test', 'get', [], [])
        );
    }

    /**
     *
     */
    public function testRequest199Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(199);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(ServerErrorException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest300Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(300);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(ServerErrorException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest404Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(404);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(ServerErrorException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest500Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(500);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(ServerErrorException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest400Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(400);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(UnknownOutputFormatException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest401Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(401);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(AuthorizationRequiredException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest402Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(402);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(NotEnoughCreditsException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest403Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(403);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(AccessDeniedException::class);
        $client->request('', '', [], []);
    }

    /**
     *
     */
    public function testRequest422Code()
    {
        $response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getReasonPhrase', 'getBody', 'hasHeader', 'getHeader'])
            ->getMock();

        $response->method('getStatusCode')
            ->willReturn(422);
        $response->method('getReasonPhrase')
            ->willReturn('');
        $response->method('getBody')
            ->willReturn($this->sampleJson);
        $response->method('hasHeader')
            ->willReturn(false);
        $response->method('getHeader')
            ->willReturn('');

        $request = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $request->method('request')
            ->willReturn($response);

        $client = new GuzzleClient($request);

        $this->expectException(InvalidMacOrOUIException::class);
        $client->request('', '', [], []);
    }
}