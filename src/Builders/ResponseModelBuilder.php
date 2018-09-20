<?php

namespace CodeLine\MacLookup\Builders;

use CodeLine\MacLookup\Exceptions\UnparsableResponseException;
use CodeLine\MacLookup\Models\BlockDetails;
use CodeLine\MacLookup\Models\MacAddressDetails;
use CodeLine\MacLookup\Models\Response;
use CodeLine\MacLookup\Models\VendorDetails;

/**
 * Class ResponseModelBuilder
 * @package CodeLine\MacLookup\Builders
 */
class ResponseModelBuilder implements ResponseModelBuilderInterface
{
    /**
     * @var
     */
    protected $jsonData;

    /**
     * ResponseModelBuilder constructor.
     * @param $jsonData
     */
    public function __construct($jsonData)
    {
        $this->jsonData = $jsonData;
    }

    /**
     * @param string $jsonData
     * @return Response
     */
    public function build($jsonData = '')
    {
        if (strlen($jsonData) <= 0)
            $jsonData = $this->jsonData;

        $blockDetails = new BlockDetails();
        $vendorDetails = new VendorDetails();
        $macAddressDetails = new MacAddressDetails();

        $responseModel = new Response(
            $this->parseJson($jsonData),
            $vendorDetails,
            $blockDetails,
            $macAddressDetails
        );

        return $responseModel;
    }

    /**
     * @param $json
     * @return mixed
     * @throws UnparsableResponseException
     */
    protected function parseJson($json)
    {
        $parsed = json_decode($json, true);

        if (is_null($parsed) || $parsed === false) {
            throw new UnparsableResponseException();
        }

        return $parsed;
    }
}