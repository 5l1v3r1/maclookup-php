<?php

namespace CodeLine\MacLookup\Exceptions;

use Throwable;


/**
 * Class AuthorizationRequiredException
 * @package CodeLine\MacLookup\Exceptions
 */
class AuthorizationRequiredException extends \Exception
{
    /**
     * AuthorizationRequiredException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($message === "")
            $message = 'The apiKey parameter is empty or missing';
        if ($code === 0)
            $code = 401;

        parent::__construct($message, $code, $previous);
    }
}