<?php

namespace CodeLine\MacLookup\Models;


/**
 * Class ResponseModel
 * @package CodeLine\MacLookup\Models
 */
class Response implements ModelInterface
{
    const VENDOR_DETAILS_KEY = 'vendorDetails';
    const BLOCK_DETAILS_KEY = 'blockDetails';
    const MAC_ADDRESS_DETAILS_KEY = 'macAddressDetails';

    /**
     * @var VendorDetails
     */
    public $vendorDetails;

    /**
     * @var BlockDetails
     */
    public $blockDetails;

    /**
     * @var MacAddressDetails
     */
    public $macAddressDetails;

    /**
     * Response constructor.
     * @param array $data
     * @param ModelInterface $vendorDetails
     * @param ModelInterface $blockDetails
     * @param ModelInterface $macAddressDetails
     */
    public function __construct(
        array $data,
        ModelInterface $vendorDetails,
        ModelInterface $blockDetails,
        ModelInterface $macAddressDetails
    )
    {
        $this->blockDetails = $blockDetails;
        $this->vendorDetails = $vendorDetails;
        $this->macAddressDetails = $macAddressDetails;

        if (count($data) > 0)
            $this->parse($data);
    }

    /**
     * @param array $data
     */
    public function parse(array $data)
    {
        $this->parseAssocArray($data);
    }

    /**
     * @param array $data
     */
    protected function parseAssocArray(array $data)
    {
        if (isset($data[static::BLOCK_DETAILS_KEY]))
            $this->blockDetails->parse($data[static::BLOCK_DETAILS_KEY]);

        if (isset($data[static::VENDOR_DETAILS_KEY]))
            $this->vendorDetails->parse($data[static::VENDOR_DETAILS_KEY]);

        if (isset($data[static::MAC_ADDRESS_DETAILS_KEY]))
            $this->macAddressDetails->parse(
                $data[static::MAC_ADDRESS_DETAILS_KEY]
            );
    }
}