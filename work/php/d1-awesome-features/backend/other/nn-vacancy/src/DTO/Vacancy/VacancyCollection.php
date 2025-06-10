<?php

declare(strict_types=1);

namespace App\DTO\Vacancy;

final readonly class VacancyCollection
{
    public function __construct(
        /** @var Vacancy[] * */
        public array $items
    ) {
    }
}
