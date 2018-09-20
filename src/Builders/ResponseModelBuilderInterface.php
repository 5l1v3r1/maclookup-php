<?php


namespace CodeLine\MacLookup\Builders;


/**
 * Interface ResponseModelBuilderInterface
 * @package CodeLine\MacLookup\Builders
 */
interface ResponseModelBuilderInterface
{
    /**
     * @param string $jsonData
     * @return \CodeLine\MacLookup\Models\Response
     * @throws \CodeLine\MacLookup\Exceptions\UnparsableResponseException
     */
    public function build($jsonData = '');
}