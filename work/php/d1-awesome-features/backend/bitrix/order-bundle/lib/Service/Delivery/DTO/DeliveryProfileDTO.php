<?php

namespace App\Bundle\Order\Service\Delivery\DTO;

use App\Bundle\Order\Service\Support\Interfaces\BaseDTO;

class DeliveryProfileDTO implements BaseDTO
{
    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $provider
     * @param string $type
     * @param string $price
     * @param string $delivery_time
     * @param DeliveryPointDTO[] $points
     * @param array $widget
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $provider,
        public string $type,
        public string $price,
        public string $delivery_time,
        public array $points,
        public array $widget,
    ) { }

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): static
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['description'],
            $data['provider'],
            $data['type'],
            $data['price'],
            $data['delivery_time'],
            $data['points'],
            $data['widget'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'provider' => $this->provider,
            'type' => $this->type,
            'price' => $this->price,
            'delivery_time' => $this->delivery_time,
            'points' => $this->points,
            'widget' => $this->widget,
        ];
    }
}