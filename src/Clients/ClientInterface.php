<?php

namespace CodeLine\MacLookup\Clients;

use CodeLine\MacLookup\Exceptions\AccessDeniedException;
use CodeLine\MacLookup\Exceptions\AuthorizationRequiredException;
use CodeLine\MacLookup\Exceptions\InvalidMacOrOUIException;
use CodeLine\MacLookup\Exceptions\NotEnoughCreditsException;
use CodeLine\MacLookup\Exceptions\ServerErrorException;
use CodeLine\MacLookup\Exceptions\UnknownOutputFormatException;


/**
 * Interface ClientInterface
 * @package CodeLine\MacLookup\Clients
 */
interface ClientInterface
{
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
    public function request($url, $method, array $payload, array $headers);
}