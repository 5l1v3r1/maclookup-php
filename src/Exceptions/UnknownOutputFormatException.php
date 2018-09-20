<?php

namespace CodeLine\MacLookup\Exceptions;

use Throwable;


/**
 * Class UnknownOutputFormatException
 * @package CodeLine\MacLookup\Exceptions
 */
class UnknownOutputFormatException extends \Exception
{
    /**
     * UnknownOutputFormatException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($message === "")
            $message = 'Unknown output format';
        if ($code === 0)
            $code = 400;

        parent::__construct($message, $code, $previous);
    }
}