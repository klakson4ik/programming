<?php

declare(strict_types=1);

namespace App\Service\Vacancy;

use App\DTO\Vacancy\VacancyCollection;
use App\Service\FilesService;
use App\Service\Parser\Exception\ParserException;
use App\Service\Parser\Exel\FromExelParser;

class VacancyFilesService
{
    /** @var string[] */
    private array $allow_file_extensions = [
        'xlsx',
    ];

    private ?VacancyCollection $collection = null;
    private int $companyId = 0;

    public function __construct(
        private readonly VacancySQLService $vacancySQLService,
        private readonly FilesService $filesService,
    ) {
    }

    public function parseLastExelFile(): self
    {
        return $this->parseExelFile(
            $this->getInputLastFile()->getPathname()
        );
    }

    public function parseFile(string $fileName): self
    {
        $pathInfo = pathinfo($fileName);

        if (!in_array($pathInfo['extension'], $this->allow_file_extensions)) {
            throw new ParserException('Not support file extension - '.$pathInfo['extension']);
        }

        if ('xlsx' === $pathInfo['extension']) {
            return $this->parseExelFile($fileName);
        }

        throw new ParserException('Not found parser form extension - '.$pathInfo['extension']);
    }

    public function parseExelFile(string $fileName): self
    {
        $this->collection = (new FromExelParser($fileName))->parse();

        return $this;
    }

    public function getSqlService(): VacancySQLService
    {
        return $this->vacancySQLService
            ->setVacanciesCollection($this->collection)
            ->setCompanyID($this->companyId);
    }

    public function saveCompanySql(): void
    {
        $this->saveCompanyFile(
            $this->getSqlService()->getFullSQL()
        );
    }

    public function saveCompanyFile(string $content): void
    {
        $this->filesService->saveContent(
            $this->getOutputPath(),
            $content
        );
    }

    public function getCollection(): ?VacancyCollection
    {
        return $this->collection;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function setCompanyId(int $companyId): self
    {
        $this->companyId = $companyId;

        return $this;
    }

    public function getOutputPath(): string
    {
        return sprintf('/output/%s Вакансии компании %s', date('Y-m-d'), $this->companyId);
    }

    private function getInputLastFile(): ?\DirectoryIterator
    {
        return $this->filesService->getLastFile('/input/', function (\DirectoryIterator $file) {
            return in_array($file->getExtension(), $this->allow_file_extensions);
        });
    }
}
