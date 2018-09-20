<?php

use Carbon\Carbon;
use CodeLine\MacLookup\Models\BlockDetails;
use CodeLine\MacLookup\Models\MacAddressDetails;
use CodeLine\MacLookup\Models\Response;
use CodeLine\MacLookup\Models\VendorDetails;
use PHPUnit\Framework\TestCase;


/**
 * Class ModelsTest
 */
class ModelsTest extends TestCase
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
		"dateUpdated": "2018-05-19"
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
     * @var array
     */
    protected $sampleData = [];

    /**
     * @var
     */
    protected $sampleBlockModel;

    /**
     * @var
     */
    protected $sampleMacModel;

    /**
     * @var
     */
    protected $sampleVendorModel;

    /**
     * @var
     */
    protected $sampleResponseModel;

    /**
     *
     */
    public function setUp()
    {
        $this->sampleData = json_decode($this->sampleJson, true);

        $blockModel = new BlockDetails();
        $blockModel->assignmentBlockSize = 'MA-L';
        $blockModel->blockFound = true;
        $blockModel->blockSize = 1099511627776;
        $blockModel->borderLeft = "08EA400000000000";
        $blockModel->borderRight = "08EA40FFFFFFFFFF";
        $blockModel->dateCreated = null;
        $blockModel->dateUpdated = Carbon::parse('2018-05-19');

        $this->sampleBlockModel = $blockModel;

        $macModel = new MacAddressDetails();
        $macModel->searchTerm = '08EA4026E5DE';
        $macModel->isValid = true;
        $macModel->transmissionType = 'multicast';
        $macModel->administrationType = 'LAA';

        $this->sampleMacModel = $macModel;

        $vendorModel = new VendorDetails();
        $vendorModel->oui = '08EA40';
        $vendorModel->isPrivate = false;
        $vendorModel->companyAddress = 'NO.268， Fuqian Rd, Jutang community, Guanlan Town, Longhua New district shenzhen  guangdong  518000 CN';
        $vendorModel->companyName = 'Shenzhen Bilian Electronic Co，Ltd';
        $vendorModel->countryCode = 'CN';

        $this->sampleVendorModel = $vendorModel;

        $responseModel = new Response(
            [],
            $this->sampleVendorModel,
            $this->sampleBlockModel,
            $this->sampleMacModel
        );

        $this->sampleResponseModel = $responseModel;
    }

    /**
     *
     */
    public function testBlockModel()
    {
        $model = new BlockDetails();

        $model->parse($this->sampleData['blockDetails']);

        $this->assertEquals($this->sampleBlockModel, $model);
    }

    /**
     *
     */
    public function testMacModel()
    {
        $model = new MacAddressDetails();

        $model->parse($this->sampleData['macAddressDetails']);

        $this->assertEquals($this->sampleMacModel, $model);
    }

    /**
     *
     */
    public function testVendorModel()
    {
        $model = new VendorDetails();

        $model->parse($this->sampleData['vendorDetails']);

        $this->assertEquals($this->sampleVendorModel, $model);
    }

    /**
     *
     */
    public function testResponseModel()
    {
        $model = new Response(
            $this->sampleData,
            new VendorDetails(),
            new BlockDetails(),
            new MacAddressDetails()
        );

        $this->assertEquals($this->sampleResponseModel, $model);
    }
}