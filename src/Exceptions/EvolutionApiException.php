<?php

declare(strict_types=1);

namespace Kalezao\EvolutionApi\Exceptions;

use Exception;

final class EvolutionApiException extends Exception
{
    public function __construct(string $message = '', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
