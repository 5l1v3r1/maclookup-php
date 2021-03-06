<?php

namespace CodeLine\MacLookup\Exceptions;

use Throwable;


/**
 * Class AccessDeniedException
 * @package CodeLine\MacLookup\Exceptions
 */
class AccessDeniedException extends \Exception
{
    /**
     * AccessDeniedException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($message === "")
            $message = 'Wrong apiKey value';
        if ($code === 0)
            $code = 403;

        parent::__construct($message, $code, $previous);
    }
}