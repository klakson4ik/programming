<?php

declare(strict_types=1);

namespace App\DTO\Vacancy;

use App\Enums\EmploymentTypes;
use App\Enums\Sex;
use App\Enums\Type;

final class Vacancy
{
    private bool $isSpecialist = false;
    private bool $isPrivate = false;
    private bool $onlyForCenter = false;
    private bool $sendToCenter = false;
    private bool $isSend = true;
    private bool $isActive = true;
    private int $headhunterID = 0;
    private string $recruiterEmail = '';
    private string $education = '';
    private string $workExperience = '';
    private string $subdivision = '';
    private string $position = '';
    private string $qualification = '';
    private string $workDuty = '';
    private string $salary = '';
    private string $workConditions = '';
    private string $contacts = '';
    private string $workActivities = '';
    private string $age = 'Старше 18 лет, согласно ст. 265 ТК РФ';
    private Sex $sex = Sex::NONE;
    private Type $type = Type::WORKER;
    private EmploymentTypes $employmentType = EmploymentTypes::DEFAULT;
    private \DateTimeImmutable $date;

    public function __construct()
    {
        $this->date = new \DateTimeImmutable();
    }

    public function isSpecialist(): bool
    {
        return $this->isSpecialist;
    }

    public function setIsSpecialist(bool $isSpecialist): self
    {
        $this->isSpecialist = $isSpecialist;

        return $this;
    }

    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    public function setIsPrivate(bool $isPrivate): self
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    public function isOnlyForCenter(): bool
    {
        return $this->onlyForCenter;
    }

    public function setOnlyForCenter(bool $onlyForCenter): self
    {
        $this->onlyForCenter = $onlyForCenter;

        return $this;
    }

    public function isSendToCenter(): bool
    {
        return $this->sendToCenter;
    }

    public function setSendToCenter(bool $sendToCenter): self
    {
        $this->sendToCenter = $sendToCenter;

        return $this;
    }

    public function isSend(): bool
    {
        return $this->isSend;
    }

    public function setIsSend(bool $isSend): self
    {
        $this->isSend = $isSend;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getHeadhunterID(): int
    {
        return $this->headhunterID;
    }

    public function setHeadhunterID(int $headhunterID): self
    {
        $this->headhunterID = $headhunterID;

        return $this;
    }

    public function getRecruiterEmail(): string
    {
        return $this->recruiterEmail;
    }

    public function setRecruiterEmail(string $recruiterEmail): self
    {
        $this->recruiterEmail = $recruiterEmail;

        return $this;
    }

    public function getEducation(): string
    {
        return $this->education;
    }

    public function setEducation(string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getWorkExperience(): string
    {
        return $this->workExperience;
    }

    public function setWorkExperience(string $workExperience): self
    {
        $this->workExperience = $workExperience;

        return $this;
    }

    public function getAge(): string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSex(): Sex
    {
        return $this->sex;
    }

    public function setSex(Sex $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSubdivision(): string
    {
        return $this->subdivision;
    }

    public function setSubdivision(string $subdivision): Vacancy
    {
        $this->subdivision = $subdivision;

        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): Vacancy
    {
        $this->position = $position;

        return $this;
    }

    public function getQualification(): string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): Vacancy
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getWorkDuty(): string
    {
        return $this->workDuty;
    }

    public function setWorkDuty(string $workDuty): Vacancy
    {
        $this->workDuty = $workDuty;

        return $this;
    }

    public function getSalary(): string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): Vacancy
    {
        $this->salary = $salary;

        return $this;
    }

    public function getWorkConditions(): string
    {
        return $this->workConditions;
    }

    public function setWorkConditions(string $workConditions): Vacancy
    {
        $this->workConditions = $workConditions;

        return $this;
    }

    public function getContacts(): string
    {
        return $this->contacts;
    }

    public function setContacts(string $contacts): Vacancy
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function getWorkActivities(): string
    {
        return $this->workActivities;
    }

    public function setWorkActivities(string $workActivities): Vacancy
    {
        $this->workActivities = $workActivities;

        return $this;
    }

    public function getEmploymentType(): EmploymentTypes
    {
        return $this->employmentType;
    }

    public function setEmploymentType(EmploymentTypes $employmentType): Vacancy
    {
        $this->employmentType = $employmentType;

        return $this;
    }
}
