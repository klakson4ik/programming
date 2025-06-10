<?php

declare(strict_types=1);

namespace App\Service\Parser\Exel\Exception;

class ExelParserInputFileEmptyException extends ExelParserException
{
    public function __construct()
    {
        parent::__construct('Файл вакансии пуст или не содержит данные вакансий');
    }
}
