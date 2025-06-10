<?php

declare(strict_types=1);

namespace App\Service\Parser\Contract;

use App\DTO\Vacancy\VacancyCollection;

interface Parser
{
    public function parse(): VacancyCollection;
}
