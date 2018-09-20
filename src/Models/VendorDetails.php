<?php

namespace CodeLine\MacLookup\Models;


/**
 * Class VendorDetails
 * @package CodeLine\MacLookup\Models
 */
class VendorDetails extends AbstractModel
{
    /**
     * @var string
     */
    public $oui;

    /**
     * @var boolean
     */
    public $isPrivate;

    /**
     * @var string
     */
    public $companyName;

    /**
     * @var string
     */
    public $companyAddress;

    /**
     * @var string
     */
    public $countryCode;
}