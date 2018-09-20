<?php

namespace CodeLine\MacLookup\Models;

use Carbon\Carbon;

/**
 * Class BlockDetails
 * @package CodeLine\MacLookup\Models
 */
class BlockDetails extends AbstractModel
{
    /**
     * @var boolean
     */
    public $blockFound;

    /**
     * @var string
     */
    public $borderLeft;

    /**
     * @var string
     */
    public $borderRight;

    /**
     * @var int|float
     */
    public $blockSize;

    /**
     * @var string
     */
    public $assignmentBlockSize;

    /**
     * @var \DateTimeInterface
     */
    public $dateCreated;

    /**
     * @var \DateTimeInterface
     */
    public $dateUpdated;

    /**
     * @param array $data
     */
    protected function parseAssocArray(array $data)
    {
        parent::parseAssocArray($data);

        $this->dateCreated = empty($this->dateCreated)
            ? null : Carbon::parse($this->dateCreated);

        $this->dateUpdated = empty($this->dateUpdated)
            ? null : Carbon::parse($this->dateUpdated);

    }
}