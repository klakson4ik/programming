<?php

declare(strict_types=1);

namespace App\Service\Parser\Exel\Exception;

class ExelParserInputFileNotFoundException extends ExelParserException
{
    public function __construct()
    {
        parent::__construct('Файл с вакансиями не обнаружен');
    }
}
