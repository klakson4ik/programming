<?php

declare(strict_types=1);

namespace App\Service\Parser\Exel;

use App\DTO\Vacancy\VacancyCollection;
use App\Service\Parser\Contract\Parser;
use App\Service\Parser\Exel\Enums\Templates;
use App\Service\Parser\Exel\Exception\ExelParserException;
use App\Service\Parser\Exel\Exception\ExelParserInputFileEmptyException;
use App\Service\Parser\Exel\Exception\ExelParserInputFileInvalidFormatException;
use App\Service\Parser\Exel\Exception\ExelParserInputFileNotFoundException;
use App\Service\Parser\Exel\Exception\ExelParserTemplateNotDefinedException;
use App\Service\Parser\Exel\SubParsers\FromOldTemplateRowsParser;
use App\Service\Parser\Exel\SubParsers\FromStandardTemplateRowsParser;
use Shuchkin\SimpleXLSX;

final readonly class FromExelParser implements Parser
{
    public function __construct(
        private string $filePath
    ) {
        if (!file_exists($this->filePath)) {
            throw new ExelParserInputFileNotFoundException();
        }

        if ('xlsx' !== strtolower(pathinfo($this->filePath)['extension'])) {
            throw new ExelParserInputFileInvalidFormatException();
        }
    }

    public function parse(): VacancyCollection
    {
        $rows = $this->getFileRows();
        $template = $this->defineTemplate($rows);

        $rows = $this->prepareRows($rows);

        return match ($template) {
            Templates::STANDARD => (new FromStandardTemplateRowsParser($rows))->parse(),
            Templates::OLD => (new FromOldTemplateRowsParser($rows))->parse(),
        };
    }

    /**
     * @param non-empty-array<array<string|int>> $rows
     */
    private function defineTemplate(array $rows): Templates
    {
        $metaRow = [];

        foreach ($rows as $row) {
            if (str_starts_with($row[0], '№')) {
                $metaRow = array_map(
                    fn ($cell) => mb_strtolower(trim(str_replace("\n", ' ', $cell ?: ''))),
                    $row
                );
                break;
            }
        }

        if (!$metaRow) {
            throw new ExelParserTemplateNotDefinedException();
        }

        if (
            'наименование подразделения' === mb_strtolower($metaRow[1])
            && str_starts_with($metaRow[2], 'внутреннее подразделение')
        ) {
            return Templates::STANDARD;
        }

        if (
            'наименование компании' === mb_strtolower($metaRow[1])
            && 'вид деятельности' === mb_strtolower($metaRow[2])
        ) {
            return Templates::OLD;
        }

        throw new ExelParserTemplateNotDefinedException();
    }

    /**
     * @return non-empty-array<array<string|int>>
     */
    private function getFileRows(): array
    {
        if (!$xlsx = SimpleXLSX::parse($this->filePath)) {
            throw new ExelParserException('Error while get file rows');
        }

        $rows = array_filter($xlsx->rows());

        if (0 === count($rows)) {
            throw new ExelParserInputFileEmptyException();
        }

        return $rows;
    }

    /**
     * @param non-empty-array<array<string|int>> $_rows
     *
     * @return non-empty-array<array<string|int>>
     */
    private function prepareRows(array $_rows): array
    {
        $rows = [];
        $type = 0;
        $canChangeType = false;

        foreach ($_rows as $row) {
            if (!is_int($row[0]) || is_int($row[1]) || !$row[1]) {
                if ($canChangeType) {
                    $type = 1;
                }

                continue;
            }

            $row['type'] = $type;
            $canChangeType = true;
            $rows[] = $row;
        }

        if (0 === count($rows)) {
            throw new ExelParserInputFileEmptyException();
        }

        return $rows;
    }
}
