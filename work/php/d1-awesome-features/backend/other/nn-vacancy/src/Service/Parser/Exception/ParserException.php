<?php

declare(strict_types=1);

namespace App\Service\Parser\Exception;

class ParserException extends \RuntimeException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
