<?php

namespace App\Bundle\Order\Service\Delivery\DTO;

use App\Bundle\Order\Service\Support\Interfaces\BaseDTO;

class DeliveryPointDTO implements BaseDTO
{
    public function __construct(
        public string $code,
        public string $address,
        public string $phone,
        public string $description,
        public array $coords,
        public string $provider,
        public string $work_time,
        public string|int|float $price,
        public string $delivery_time,
        public array $extra_data = []
    ) { }

    public static function fromArray(array $data): static
    {
        return new self(
            $data['code'],
            $data['address'],
            $data['phone'],
            $data['description'],
            $data['coords'],
            $data['provider'],
            $data['work_time'],
            $data['price'],
            $data['delivery_time'],
            $data['extra'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'address' => $this->address,
            'phone' => $this->phone,
            'description' => $this->description,
            'coords' => $this->coords,
            'provider' => $this->provider,
            'work_time' => $this->work_time,
            'price' => $this->price,
            'delivery_time' => $this->delivery_time,
            'extra' => $this->extra_data,
        ];
    }
}