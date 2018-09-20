<?php

namespace CodeLine\MacLookup;

use CodeLine\MacLookup\Builders\ResponseModelBuilderInterface;
use CodeLine\MacLookup\Clients\ClientInterface;
use CodeLine\MacLookup\Exceptions\AccessDeniedException;
use CodeLine\MacLookup\Exceptions\AuthorizationRequiredException;
use CodeLine\MacLookup\Exceptions\EmptyResponseException;
use CodeLine\MacLookup\Exceptions\InvalidMacOrOUIException;
use CodeLine\MacLookup\Exceptions\NotEnoughCreditsException;
use CodeLine\MacLookup\Exceptions\ServerErrorException;
use CodeLine\MacLookup\Exceptions\UnknownOutputFormatException;


/**
 * Class ApiClient
 * @package CodeLine\MacLookup
 */
class ApiClient implements ApiClientInterface
{
    const API_BASE_URL = 'https://api.macaddress.io/v1';
    const USER_AGENT_BASE = 'PHP Client library/';
    const VERSION = '1.0.0';

    const SEARCH_F = 'search';
    const FORMAT_F = 'output';

    const VENDOR_OUTPUT_FORMAT = 'vendor';
    const PARSABLE_OUTPUT_FORMAT = 'json';
    const REQUEST_METHOD = 'get';

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ResponseModelBuilderInterface
     */
    protected $builder;

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $apiKey;

    /**
     * ApiClient constructor.
     * @param ClientInterface $client
     * @param ResponseModelBuilderInterface $builder
     * @param $apiKey
     * @param string $url
     */
    public function __construct(
        ClientInterface $client,
        ResponseModelBuilderInterface $builder,
        $apiKey,
        $url = ""
    )
    {
        $this->client = $client;
        $this->builder = $builder;
        $this->setApiKey($apiKey);

        if ($url === "") {
            $this->setBaseUrl(static::API_BASE_URL);
        } else {
            $this->setBaseUrl($url);
        }
    }

    /**
     * @param $mac
     * @return Models\Response
     * @throws EmptyResponseException
     * @throws ServerErrorException
     * @throws UnknownOutputFormatException
     * @throws AuthorizationRequiredException
     * @throws NotEnoughCreditsException
     * @throws AccessDeniedException
     * @throws InvalidMacOrOUIException
     */
    public function get($mac)
    {
        $payload = [
            static::SEARCH_F => $mac,
            static::FORMAT_F => static::PARSABLE_OUTPUT_FORMAT,
        ];

        $response = $this->client->request(
            $this->url,
            static::REQUEST_METHOD,
            $payload,
            $this->buildCustomHeaders()
        );

        if (strlen($response) <= 0) {
            throw new EmptyResponseException();
        }

        return $this->builder->build($response);
    }

    /**
     * @param $mac
     * @param string $format
     * @return string
     * @throws EmptyResponseException
     * @throws ServerErrorException
     * @throws UnknownOutputFormatException
     * @throws AuthorizationRequiredException
     * @throws NotEnoughCreditsException
     * @throws AccessDeniedException
     * @throws InvalidMacOrOUIException
     */
    public function getRawData($mac, $format = 'json')
    {
        $payload = [
            static::SEARCH_F => $mac,
            static::FORMAT_F => $format,
        ];

        $response = $this->client->request(
            $this->url,
            static::REQUEST_METHOD,
            $payload,
            $this->buildCustomHeaders()
        );

        if (strlen($response) <= 0) {
            throw new EmptyResponseException();
        }

        return $response;
    }

    /**
     * @param $mac
     * @return string
     * @throws ServerErrorException
     * @throws UnknownOutputFormatException
     * @throws AuthorizationRequiredException
     * @throws NotEnoughCreditsException
     * @throws AccessDeniedException
     * @throws InvalidMacOrOUIException
     */
    public function getVendorName($mac)
    {
        $payload = [
            static::SEARCH_F => $mac,
            static::FORMAT_F => static::VENDOR_OUTPUT_FORMAT,
        ];

        $response = $this->client->request(
            $this->url,
            static::REQUEST_METHOD,
            $payload,
            $this->buildCustomHeaders()
        );

        return $response;
    }

    /**
     * @param $apiKey
     */
    public function setApiKey($apiKey)
    {
        if (!empty($apiKey) && is_string($apiKey))
            $this->apiKey = $apiKey;
    }

    /**
     * @param $url
     */
    public function setBaseUrl($url)
    {
        if (!empty($url) && is_string($url))
            $this->url = $url;
    }

    /**
     * @return array
     */
    protected function buildCustomHeaders()
    {
        return [
            'X-Authentication-Token' => $this->apiKey,
            'User-Agent' => static::USER_AGENT_BASE . static::VERSION,
        ];
    }
}