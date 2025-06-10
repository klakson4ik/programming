<?php

declare(strict_types=1);

namespace App\Service\Parser\Exel\SubParsers;

use App\DTO\Vacancy\Vacancy;
use App\DTO\Vacancy\VacancyCollection;
use App\Enums\EmploymentTypes;
use App\Enums\Type;
use App\Service\Parser\Contract\Parser;

final readonly class FromOldTemplateRowsParser implements Parser
{
    public function __construct(
        /** @var non-empty-array<array<string|int>> $rows */
        private array $rows
    ) {
    }

    public function parse(): VacancyCollection
    {
        $vacancies = array_map(
            function (array $row) {
                return (new Vacancy())
                    ->setIsSpecialist(1 === $row['type'])
                    ->setType(1 === $row['type'] ? Type::SPECIALIST : Type::WORKER)
                    ->setRecruiterEmail($row[19])
                    ->setSubdivision($this->getSubdivisionByRow($row))
                    ->setPosition($this->getPositionByRow($row))
                    ->setQualification($row[12])
                    ->setWorkDuty($row[11])
                    ->setSalary($this->getSalaryByRow($row))
                    ->setWorkConditions($row[18])
                    ->setContacts($row[20])
                    ->setWorkActivities($row[2])
                    ->setEmploymentType($this->getEmploymentTypeByRow($row));
            },
            $this->rows
        );

        return new VacancyCollection($vacancies);
    }

    /**
     * @param array<string|int> $row
     */
    private function getEmploymentTypeByRow(array $row): EmploymentTypes
    {
        if ('вахтовый метод' === mb_strtolower($row[14])) {
            return EmploymentTypes::SHIFT;
        }

        if ('временная' === mb_strtolower($row[14])) {
            return EmploymentTypes::TEMPORARY;
        }

        return EmploymentTypes::DEFAULT;
    }

    /**
     * @param array<string|int> $row
     */
    private function getSalaryByRow(array $row): string
    {
        if (1 === $row['type']) {
            return '';
        }

        return number_format(intval($row[10]), 0, '', ' ');
    }

    /**
     * @param array<string|int> $row
     */
    private function getSubdivisionByRow(array $row): string
    {
        $subdivision = '';

        if (!empty($row[3])) {
            $subdivision = $row[3];
        }

        if (!empty($row[4])) {
            $subdivision = !empty($row[3])
                ? $row[3].' / '.$row[4]
                : $row[4];
        }

        return $subdivision;
    }

    /**
     * @param array<string|int> $row
     */
    private function getPositionByRow(array $row): string
    {
        $position = $row[5];

        if (
            1 !== $row['type']
            && (
                str_replace(' ', '', (string) $row[6]) > 0
                && str_replace(' ', '', (string) $row[6]) < 100
            )
        ) {
            $position .= ' '.$row[6].' разряда';
        }

        return $position;
    }
}
