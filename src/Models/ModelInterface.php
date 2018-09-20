<?php

namespace CodeLine\MacLookup\Models;


/**
 * Interface ModelInterface
 * @package CodeLine\MacLookup\Models
 */
interface ModelInterface
{
    /**
     * @param array $data
     */
    public function parse(array $data);
}