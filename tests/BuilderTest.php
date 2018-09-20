<?php

use CodeLine\MacLookup\ApiClient;
use CodeLine\MacLookup\Builders\ClientBuilder;
use CodeLine\MacLookup\Builders\ResponseModelBuilder;
use CodeLine\MacLookup\Clients\GuzzleClient;
use CodeLine\MacLookup\Exceptions\UnparsableResponseException;
use CodeLine\MacLookup\Models\BlockDetails;
use CodeLine\MacLookup\Models\MacAddressDetails;
use CodeLine\MacLookup\Models\Response;
use CodeLine\MacLookup\Models\VendorDetails;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;


/**
 * Class BuilderTest
 */
class BuilderTest extends TestCase
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
    protected $url = 'https://api.macaddress.io/v0';


    /**
     *
     */
    public function testParsing()
    {
        $blockDetails = new BlockDetails();
        $vendorDetails = new VendorDetails();
        $macAddressDetails = new MacAddressDetails();

        $responseModel = new Response(
            json_decode($this->sampleJson, true),
            $vendorDetails,
            $blockDetails,
            $macAddressDetails
        );

        $builder = new ResponseModelBuilder('');

        $this->assertEquals($responseModel, $builder->build($this->sampleJson));
    }

    /**
     *
     */
    public function testParsingFailure()
    {
        $builder = new ResponseModelBuilder('');

        $this->expectException(UnparsableResponseException::class);

        $builder->build('smth good');
    }

    /**
     *
     */
    public function testClientBuilder()
    {
        $builder = new ResponseModelBuilder('');
        $client = new GuzzleClient(new Client());

        $valid = new ApiClient($client, $builder, $this->apiKey, $this->url);

        $clientBuilder = new ClientBuilder();

        $test = $clientBuilder->build($this->apiKey, $this->url);

        $this->assertEquals($valid, $test);
    }
}