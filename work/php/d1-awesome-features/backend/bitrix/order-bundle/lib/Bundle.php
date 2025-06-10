<?php

namespace App\Bundle\Order;

class Bundle extends \TAO\Bundle
{
	public function routes(): array
    {
		return [
			'{^/order/location/get/$}' => [
                'controller' => 'Controller',
                'action' => 'getLocation'
            ],
            '{^/order/delivery/pickup/points/$}' => [
                'controller' => 'Controller',
                'action' => 'getPickupPoints'
            ],
            '{^/order/create/$}' => [
                'controller' => 'Controller',
                'action' => 'create'
            ],
            '{^/order/ajax/$}' => [
                'controller' => 'Controller',
                'action' => 'index'
            ]
        ];
	}
}
