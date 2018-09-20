<?php

namespace CodeLine\MacLookup\Exceptions;

use Throwable;


/**
 * Class InvalidMacOrOUIException
 * @package CodeLine\MacLookup\Exceptions
 */
class InvalidMacOrOUIException extends \Exception
{
    /**
     * InvalidMacOrOUIException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($message === "")
            $message = 'Invalid MAC or OUI';
        if ($code === 0)
            $code = 422;

        parent::__construct($message, $code, $previous);
    }
}