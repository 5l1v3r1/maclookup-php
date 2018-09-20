<?php

namespace CodeLine\MacLookup\Clients;

use CodeLine\MacLookup\Exceptions\AccessDeniedException;
use CodeLine\MacLookup\Exceptions\AuthorizationRequiredException;
use CodeLine\MacLookup\Exceptions\InvalidMacOrOUIException;
use CodeLine\MacLookup\Exceptions\NotEnoughCreditsException;
use CodeLine\MacLookup\Exceptions\ServerErrorException;
use CodeLine\MacLookup\Exceptions\UnknownOutputFormatException;
use GuzzleHttp\ClientInterface as GuzzleInterface;

/**
 * Class GuzzleClient
 * @package CodeLine\MacLookup\Clients
 */
class GuzzleClient implements ClientInterface
{
    const DEPRECATED_HEADER_KEY = 'Warning';

    /**
     * @var array
     */
    protected $errorExceptionsMapping = [
        400 => UnknownOutputFormatException::class,
        401 => AuthorizationRequiredException::class,
        402 => NotEnoughCreditsException::class,
        403 => AccessDeniedException::class,
        422 => InvalidMacOrOUIException::class,
    ];

    /**
     * @var GuzzleInterface
     */
    protected $client;

    /**
     * GuzzleClient constructor.
     * @param GuzzleInterface $client
     */
    public function __construct(
        GuzzleInterface $client
    )
    {
        $this->client = $client;
    }

    /**
     * @param $url
     * @param $method
     * @param array $payload
     * @param array $headers
     * @return string
     * @throws ServerErrorException
     * @throws UnknownOutputFormatException
     * @throws AuthorizationRequiredException
     * @throws NotEnoughCreditsException
     * @throws AccessDeniedException
     * @throws InvalidMacOrOUIException
     */
    public function request($url, $method, array $payload, array $headers)
    {
        $payloadKey = (strtolower($method) === 'get') ? 'query' : 'body';

        $headers = $headers + ['Connection' => 'close'];

        $response = $this->client->request(
            strtoupper($method),
            $url,
            [
                $payloadKey => $payload,
                'headers' => $headers,
                'http_errors' => false,
            ]
        );

        $code = $response->getStatusCode();

        if (in_array($code, array_keys($this->errorExceptionsMapping)))
            throw new $this->errorExceptionsMapping[$code]();

        if ($code < 200 || $code >= 300) {
            throw new ServerErrorException(
                $response->getReasonPhrase(),
                $response->getStatusCode()
            );
        }

        $stringBody = (string)$response->getBody();

        if ($response->hasHeader(static::DEPRECATED_HEADER_KEY)) {
            trigger_error(
                $response->getHeader(static::DEPRECATED_HEADER_KEY),
                E_USER_DEPRECATED
            );
        }

        $response->getBody()->close();

        return $stringBody;
    }
}