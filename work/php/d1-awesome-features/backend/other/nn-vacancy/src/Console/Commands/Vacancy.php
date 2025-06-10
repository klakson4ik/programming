<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\IO\InputOutput;
use App\Service\FilesService;
use App\Service\Vacancy\VacancyFilesService;
use App\Service\Vacancy\VacancySQLService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'vacancy',
    description: 'Собирает sql запрос из данных по вакансиям в файле vacancy.xlsx',
	aliases: ['v']
)]
final class Vacancy extends Command
{
    private readonly VacancyFilesService $vacancyFilesService;

    public function __construct(?string $name = null)
    {
        parent::__construct($name);

        $this->vacancyFilesService = new VacancyFilesService(
            new VacancySQLService(),
            new FilesService(__DIR__.'/../../../resource')
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new InputOutput($input, $output);
        $companyID = (int) $io->question('Введите ID компании');

        if (!$companyID) {
            $io->message('Не верный ID компании');

            return Command::FAILURE;
        }

        $this->vacancyFilesService->setCompanyId($companyID);
        $this->vacancyFilesService->parseLastExelFile();
        $this->vacancyFilesService->saveCompanySql();

        $io->message('SQL записан в '.$this->vacancyFilesService->getOutputPath());

        return Command::SUCCESS;
    }
}
