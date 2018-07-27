<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class Custom
 * @package App\Exceptions
 */
class Custom extends Exception
{
    /**
     * Custom constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     *
     */
    public function render()
    {
        abort($this->code, $this->message);
    }
}
