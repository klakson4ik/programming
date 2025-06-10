<?php

declare(strict_types=1);

namespace App\Enums;

enum EmploymentTypes: string
{
    use AccessTrait;

    case NONE = '0';
    case SHIFT = '1';
    case TEMPORARY = '3';
    case DEFAULT = '2';
}
