<?php

namespace plugin\jicang\exception;

use Throwable;
class ApiException extends \RuntimeException
{
    public function __construct($message, $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}