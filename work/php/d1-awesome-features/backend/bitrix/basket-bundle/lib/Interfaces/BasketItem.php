<?php

namespace App\Bundle\Basket\Interfaces;

interface BasketItem
{
    public function getField(string $field): mixed;

    public function setField(string $code, mixed $field): object;

    public function setFields(array $fields): object;

    public function delete(): object;

    public function save(): void;

    public function create(int $quantity = 1, $fields = [], $props = []): object;

    public function setQuantity(int $quantity): object;

    public function setProperties(array $data): void;

    public function setProperty(array $data, bool $is_arrays = false): void;

    public function toArray(): array;

    public function getPropertyCollection(): object;

    public function __get(string $property);
}