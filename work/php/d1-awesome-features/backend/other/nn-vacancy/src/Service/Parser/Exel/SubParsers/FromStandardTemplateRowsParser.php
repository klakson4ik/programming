<?php

declare(strict_types=1);

namespace App\Service\Parser\Exel\SubParsers;

use App\DTO\Vacancy\Vacancy;
use App\DTO\Vacancy\VacancyCollection;
use App\Enums\EmploymentTypes;
use App\Enums\Type;
use App\Service\Parser\Contract\Parser;

final readonly class FromStandardTemplateRowsParser implements Parser
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
                    ->setQualification($row[10])
                    ->setWorkDuty($row[9])
                    ->setSalary($this->getSalaryByRow($row))
                    ->setWorkConditions($row[16])
                    ->setContacts($row[17])
                    ->setWorkActivities($row[18])
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
        if ('вахтовый метод' === mb_strtolower($row[12])) {
            return EmploymentTypes::SHIFT;
        }

        if ('временная' === mb_strtolower($row[12])) {
            return EmploymentTypes::TEMPORARY;
        }

        return EmploymentTypes::DEFAULT;
    }

    /**
     * @param array<string|int> $row
     */
    private function getSalaryByRow(array $row): string
    {
        $salaryRange = explode(PHP_EOL, (string) $row[8]);
        $from = number_format((int) str_replace(' ', '', (string) $salaryRange[0]), 0, '', ' ');

        if (count($salaryRange) > 1 && 1 !== $row['type']) {
            $to = number_format((int) str_replace(' ', '', (string) $salaryRange[1]), 0, '', ' ');

            return 'от '.$from.' до '.$to;
        }

        return 1 !== $row['type'] ? $from : '';
    }

    /**
     * @param array<string|int> $row
     */
    private function getSubdivisionByRow(array $row): string
    {
        $subdivision = '';

        if (!empty($row[1])) {
            $subdivision = $row[1];
        }

        if (!empty($row[2])) {
            $subdivision = !empty($row[1])
                ? $row[1].' / '.$row[2]
                : $row[2];
        }

        return $subdivision;
    }

    /**
     * @param array<string|int> $row
     */
    private function getPositionByRow(array $row): string
    {
        $position = $row[3];

        if (
            1 !== $row['type']
            && (
                str_replace(' ', '', (string) $row[4]) > 0
                && str_replace(' ', '', (string) $row[4]) < 100
            )
        ) {
            $position .= ' '.$row[4].' разряда';
        }

        return $position;
    }
}
