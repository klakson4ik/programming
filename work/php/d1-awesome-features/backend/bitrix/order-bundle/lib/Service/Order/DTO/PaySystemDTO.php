<?php

namespace App\Bundle\Order\Service\Order\DTO;

class PaySystemDTO
{
    public function __construct(
        public int $id,
        public int $pay_system_id,
        public string $name,
        public string $description
    ) { }

    public static function fromArray(array $data): PaySystemDTO
    {
        return new self(
            $data['ID'],
            $data['PAY_SYSTEM_ID'],
            $data['NAME'],
            $data['DESCRIPTION'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'pay_system_id' => $this->pay_system_id,
            'description' => $this->description,
        ];
    }
}