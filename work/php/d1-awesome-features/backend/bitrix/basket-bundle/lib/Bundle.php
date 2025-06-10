<?php

namespace App\Bundle\Basket;

class Bundle extends \TAO\Bundle
{
	public function routes(): array
    {
		return [
            '{^/basket/get/$}' => [
                'controller' => 'Controller',
                'action' => 'get'
            ],
            '{^/basket/coupon/add/$}' => [
                'controller' => 'Controller',
                'action' => 'addCoupon'
            ],
            '{^/basket/coupon/remove/$}' => [
                'controller' => 'Controller',
                'action' => 'removeCoupon'
            ],
            '{^/basket/items/$}' => [
                '{1}',
                'controller' => 'Controller',
                'action' => 'items'
            ],
            '{^/basket/clear/$}' => [
                '{1}',
                'controller' => 'Controller',
                'action' => 'clear'
            ],
			'{^/basket/add/(\d+)/$}' => [
                '{1}',
                'controller' => 'Controller',
                'action' => 'add'
            ],
            '{^/basket/remove/(\d+)/$}' => [
                '{1}',
                'controller' => 'Controller',
                'action' => 'remove'
            ],
            '{^/basket/quantity/(\d+)/(\d+)/$}' => [
                '{1}',
                '{2}',
                'controller' => 'Controller',
                'action' => 'quantity'
            ],
        ];
	}
}
