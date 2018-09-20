<?php

namespace CodeLine\MacLookup\Builders;


use CodeLine\MacLookup\ApiClient;
use CodeLine\MacLookup\Clients\GuzzleClient;
use GuzzleHttp\Client;

/**
 * Class ClientBuilder
 * @package CodeLine\MacLookup\Builders
 */
class ClientBuilder implements ClientBuilderInterface
{

    /**
     * @param string $apiKey
     * @param string $url
     * @return ApiClient
     */
    public function build($apiKey, $url = '')
    {
        $builder = new ResponseModelBuilder('');
        $client = new GuzzleClient(new Client());

        return new ApiClient($client, $builder, $apiKey, $url);
    }
}