<?php

namespace App\Bundle\Order\Service\Support;

class Helper
{
    public static function validateArrayKey(array $array, mixed $key, string $message): array
    {
        return [
            'value' => $array[$key],
            'error' => !$array[$key],
            'message' => $array[$key] ? '' : $message
        ];
    }
}