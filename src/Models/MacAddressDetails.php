<?php

namespace CodeLine\MacLookup\Models;


/**
 * Class MacAddressDetails
 * @package CodeLine\MacLookup\Models
 */
class MacAddressDetails extends AbstractModel
{
    /**
     * @var string
     */
    public $searchTerm;

    /**
     * @var boolean
     */
    public $isValid;

    /**
     * @var string
     */
    public $transmissionType;

    /**
     * @var string
     */
    public $administrationType;
}