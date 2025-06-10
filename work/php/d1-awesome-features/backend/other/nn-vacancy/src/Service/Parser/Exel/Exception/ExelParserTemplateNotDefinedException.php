<?php

declare(strict_types=1);

namespace App\Service\Parser\Exel\Exception;

class ExelParserTemplateNotDefinedException extends ExelParserException
{
    public function __construct()
    {
        parent::__construct('Не удалось определить шаблон вакансии');
    }
}
