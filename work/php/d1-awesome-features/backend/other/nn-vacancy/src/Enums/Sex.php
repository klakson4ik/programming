<?php

declare(strict_types=1);

namespace App\Enums;

enum Sex: string
{
    use AccessTrait;

    case MALE = '1';
    case FEMALE = '2';
    case NONE = '0';
}
