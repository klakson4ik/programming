<?php

namespace App\Bundle\Order\Service\Support\Interfaces;

interface BaseDTO
{
    public static function fromArray(array $data): static;

    public function toArray(): array;
}