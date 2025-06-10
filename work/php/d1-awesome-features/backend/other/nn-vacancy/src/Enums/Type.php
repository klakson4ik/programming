<?php

declare(strict_types=1);

namespace App\Enums;

enum Type: string
{
    use AccessTrait;

    case WORKER = '1';
    case SPECIALIST = '2';
}
