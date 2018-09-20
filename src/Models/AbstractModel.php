<?php

namespace CodeLine\MacLookup\Models;


/**
 * Class AbstractModel
 * @package CodeLine\MacLookup\Models
 */
abstract class AbstractModel implements ModelInterface
{
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
        foreach ($data as $key => $value) {
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

}