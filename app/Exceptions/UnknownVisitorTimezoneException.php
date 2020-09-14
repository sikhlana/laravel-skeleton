<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UnknownVisitorTimezoneException extends BadRequestHttpException
{
    public function __construct(\Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct('The system was unable to determine your timezone.', $previous, $code, $headers);
    }
}
