<?php

declare(strict_types=1);

namespace App\Enums;

use App\Exception\EnumAccessException;

trait AccessTrait
{
    public static function getEnumByValue(mixed $value): self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }

        throw new EnumAccessException('Not found value: '.$value.' in '.__CLASS__.' enum');
    }
}
