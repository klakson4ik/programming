<?php

namespace App\Bundle\Basket\Interfaces;

interface Basket
{
    public static function getInstance(): self;

    public function addCoupon(string $coupon): bool;

    public function removeCoupon(string $coupon): bool;

    public function clearCoupons(): void;

    public function getItems(): array;

    public function getItemsArray(): array;

    public function getBasketArray(): array;

    public function getPositionsList(): array;

    public function getItemsCount(): float|int;

    public function getPositionsCount(): int;

    public function getWeight(): float|int;

    public function addProducts(array $products): void;

    public function addProduct(int $product_id, int $quantity = 1, array $fields = [], array $props = []): object;

    public function clear(): void;

    public function removeItemsById(array $ids): void;

    public function removeItemsByProductId(array $products_ids): void;

    public function changeItemQuantityById(int $id, int $quantity): array;

    public function changeItemQuantityByProductId(int $product_id, int $quantity): array;

    public function removeItemByProductId(int $product_id): object;

    public function removeItemById(int $id): object;

    public function save(): void;

    public function getBasePrice(): int|float;

    public function getPrice(): int|float;

    public function loadBitrixBasketByFUser(): void;

    public function loadBitrixBasketByOrderId(string|int $order_id): void;

    public function refresh(): void;

    public function refreshData(array $fields): void;

    public function reload(): void;

    public function toArray(): array;

    public function getItemByProductId(int $product_id): BasketItem;

    public function getItemById(int $id): BasketItem;
}