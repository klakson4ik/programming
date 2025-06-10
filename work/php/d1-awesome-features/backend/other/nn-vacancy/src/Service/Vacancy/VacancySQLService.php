<?php

declare(strict_types=1);

namespace App\Service\Vacancy;

use App\DTO\Vacancy\Vacancy;
use App\DTO\Vacancy\VacancyCollection;

final class VacancySQLService
{
    private int $companyID;
    private VacancyCollection $vacanciesCollection;

    public function getFullSQL(): string
    {
        return $this->getDeleteSQl().PHP_EOL.$this->getInsertDataSQL();
    }

    public function getDeleteSQl(): string
    {
        return sprintf('DELETE FROM vacancyreg WHERE company_id = %s;', $this->companyID);
    }

    public function getInsertDataSQL(): string
    {
        $sql = '';

        foreach ($this->vacanciesCollection->items as $vacancy) {
            $sql .= PHP_EOL.$this->makeDataString($vacancy);
        }

        return $this->getSQLStartString().rtrim($sql, ',');
    }

    public function getCompanyID(): int
    {
        return $this->companyID;
    }

    public function setCompanyID(int $companyID): self
    {
        $this->companyID = $companyID;

        return $this;
    }

    public function getVacanciesCollection(): VacancyCollection
    {
        return $this->vacanciesCollection;
    }

    public function setVacanciesCollection(VacancyCollection $vacanciesCollection): self
    {
        $this->vacanciesCollection = $vacanciesCollection;

        return $this;
    }

    private function makeDataString(Vacancy $vacancy): string
    {
        $data = array_map(function ($el) {
            return sprintf("'%s'", $el);
        }, [
            $this->companyID,
            $vacancy->getSubdivision(),
            $vacancy->getDate()->getTimestamp(),
            $vacancy->getPosition(),
            $vacancy->getSex()->value,
            $vacancy->getEducation(),
            $vacancy->getAge(),
            $vacancy->getWorkExperience(),
            $vacancy->getQualification(),
            $vacancy->getWorkDuty(),
            $vacancy->getWorkConditions(),
            $vacancy->getSalary(),
            $vacancy->getType()->value,
            $vacancy->isActive() ? '1' : '0',
            $vacancy->isSend() ? '1' : '',
            $vacancy->getHeadhunterID(),
            $vacancy->getContacts(),
            $vacancy->getRecruiterEmail(),
            $vacancy->getWorkActivities(),
            $vacancy->isSendToCenter() ? '1' : '0',
            $vacancy->isOnlyForCenter() ? '1' : '0',
            $vacancy->getEmploymentType()->value,
            $vacancy->isPrivate() ? '1' : '0',
            $vacancy->getDate()->getTimestamp(),
        ]);

        return '(null,'.implode(',', $data).',null),';
    }

    private function getSQLStartString(): string
    {
        return "INSERT INTO vacancyreg (
    vacancyreg_id,
    company_id,
    subdivision,
    publishdate,
    position,
    sex,
    education,
    age,
    proflevel,
    qualification,
    duty,
    other,
    solary,
    vacancytype,
    is_show,
    is_send,
    haedhanter_id,
    vacancycontact,
    recruiter_email,
    activities,
    center,
    only_center,
    employment_type,
    is_private,
    date_public,
    private_hash\n)\nVALUES";
    }
}
