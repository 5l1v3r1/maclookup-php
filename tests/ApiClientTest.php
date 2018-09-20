<?php

use CodeLine\MacLookup\ApiClient;
use CodeLine\MacLookup\Builders\ResponseModelBuilder;
use CodeLine\MacLookup\Clients\GuzzleClient;
use CodeLine\MacLookup\Exceptions\EmptyResponseException;
use PHPUnit\Framework\TestCase;


/**
 * Class ApiClientTest
 */
class ApiClientTest extends TestCase
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
     * @var string
     */
    protected $apiKey = 'test_key';

    /**
     * @var string
     */
    protected $sampleVendor = 'Shenzhen Bilian Electronic Co，Ltd';

    /**
     * @var string
     */
    protected $url = 'https://api.macaddress.io/v0';

    /**
     *
     */
    public function testGetMethod()
    {
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('https://api.macaddress.io/v1'),
                $this->equalTo('get'),
                $this->equalTo(['search' => '08EA40', 'output' => 'json']),
                $this->equalTo([
                    'X-Authentication-Token' => 'test_key',
                    'User-Agent' => 'PHP Client library/1.0.0'
                ])
            )
            ->willReturn($this->sampleJson);

        $builder = new ResponseModelBuilder('');

        $builderValid = new ResponseModelBuilder($this->sampleJson);

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->assertEquals($builderValid->build(), $client->get('08EA40'));
    }

    /**
     *
     */
    public function testGetMethodEmptyResponse()
    {
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('https://api.macaddress.io/v1'),
                $this->equalTo('get'),
                $this->equalTo(['search' => '08EA40', 'output' => 'json']),
                $this->equalTo([
                    'X-Authentication-Token' => 'test_key',
                    'User-Agent' => 'PHP Client library/1.0.0'
                ])
            )
            ->willReturn('');

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->expectException(EmptyResponseException::class);

        $client->get('08EA40');
    }

    /**
     *
     */
    public function testGetVendorMethod()
    {
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('https://api.macaddress.io/v1'),
                $this->equalTo('get'),
                $this->equalTo(['search' => '08EA40', 'output' => 'vendor']),
                $this->equalTo([
                    'X-Authentication-Token' => 'test_key',
                    'User-Agent' => 'PHP Client library/1.0.0'
                ])
            )
            ->willReturn($this->sampleVendor);

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->assertEquals(
            $this->sampleVendor,
            $client->getVendorName('08EA40')
        );
    }

    /**
     *
     */
    public function testGetRawDataMethod()
    {
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('https://api.macaddress.io/v1'),
                $this->equalTo('get'),
                $this->equalTo(['search' => '08EA40', 'output' => 'json']),
                $this->equalTo([
                    'X-Authentication-Token' => 'test_key',
                    'User-Agent' => 'PHP Client library/1.0.0'
                ])
            )
            ->willReturn($this->sampleJson);

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->assertEquals(
            $this->sampleJson,
            $client->getRawData('08EA40', 'json')
        );
    }

    /**
     *
     */
    public function testGetRawDataMethodEmptyResponse()
    {
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('https://api.macaddress.io/v1'),
                $this->equalTo('get'),
                $this->equalTo(['search' => '08EA40', 'output' => 'json']),
                $this->equalTo([
                    'X-Authentication-Token' => 'test_key',
                    'User-Agent' => 'PHP Client library/1.0.0'
                ])
            )
            ->willReturn('');

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient($requestMock, $builder, $this->apiKey);

        $this->expectException(EmptyResponseException::class);

        $client->getRawData('08EA40', 'json');
    }

    /**
     *
     */
    public function testApiClientCustomUrl()
    {
        $requestMock = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('https://api.macaddress.io/v0'),
                $this->equalTo('get'),
                $this->equalTo(['search' => '08EA40', 'output' => 'vendor']),
                $this->equalTo([
                    'X-Authentication-Token' => 'test_key',
                    'User-Agent' => 'PHP Client library/1.0.0'
                ])
            )
            ->willReturn($this->sampleVendor);

        $builder = new ResponseModelBuilder('');

        $client = new ApiClient(
            $requestMock,
            $builder,
            $this->apiKey,
            $this->url
        );

        $this->assertEquals(
            $this->sampleVendor,
            $client->getVendorName('08EA40')
        );
    }
}