<?php

namespace CodeLine\MacLookup\Builders;


/**
 * Interface ClientBuilderInterface
 * @package CodeLine\MacLookup\Builders
 */
interface ClientBuilderInterface
{
    /**
     * @param string $apiKey
     * @param string $url
     * @return \CodeLine\MacLookup\ApiClient
     */
    public function build($apiKey, $url = '');
}