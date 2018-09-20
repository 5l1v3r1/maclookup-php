<?php

namespace CodeLine\MacLookup\Exceptions;

use Throwable;


/**
 * Class NotEnoughCreditsException
 * @package CodeLine\MacLookup\Exceptions
 */
class NotEnoughCreditsException extends \Exception
{
    /**
     * NotEnoughCreditsException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($message === "")
            $message = 'Insufficient balance';
        if ($code === 0)
            $code = 402;

        parent::__construct($message, $code, $previous);
    }
}