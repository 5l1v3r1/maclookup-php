<?php

namespace CodeLine\MacLookup;

use CodeLine\MacLookup\Exceptions\AccessDeniedException;
use CodeLine\MacLookup\Exceptions\AuthorizationRequiredException;
use CodeLine\MacLookup\Exceptions\EmptyResponseException;
use CodeLine\MacLookup\Exceptions\InvalidMacOrOUIException;
use CodeLine\MacLookup\Exceptions\NotEnoughCreditsException;
use CodeLine\MacLookup\Exceptions\ServerErrorException;
use CodeLine\MacLookup\Exceptions\UnknownOutputFormatException;

/**
 * Interface ApiClientInterface
 */
interface ApiClientInterface
{
    /**
     * @param string $url Base API URl
     */
    public function setBaseUrl($url);

    /**
     * @param string $apiKey Your API key
     */
    public function setApiKey($apiKey);

    /**
     * @param string $mac Mac address or OUI
     * @return \CodeLine\MacLookup\Models\Response
     * @throws EmptyResponseException
     * @throws ServerErrorException
     * @throws UnknownOutputFormatException
     * @throws AuthorizationRequiredException
     * @throws NotEnoughCreditsException
     * @throws AccessDeniedException
     * @throws InvalidMacOrOUIException
     */
    public function get($mac);

    /**
     * @param string $mac Mac address or OUI
     * @param string $format Supported formats json/xml/csv/vendor
     * @return string
     * @throws EmptyResponseException
     * @throws ServerErrorException
     * @throws UnknownOutputFormatException
     * @throws AuthorizationRequiredException
     * @throws NotEnoughCreditsException
     * @throws AccessDeniedException
     * @throws InvalidMacOrOUIException
     */
    public function getRawData($mac, $format = 'json');

    /**
     * @param string $mac Mac address or OUI
     * @return string
     * @throws ServerErrorException
     * @throws UnknownOutputFormatException
     * @throws AuthorizationRequiredException
     * @throws NotEnoughCreditsException
     * @throws AccessDeniedException
     * @throws InvalidMacOrOUIException
     */
    public function getVendorName($mac);
}