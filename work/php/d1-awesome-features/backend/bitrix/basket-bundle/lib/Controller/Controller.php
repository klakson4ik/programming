<?php

namespace App\Bundle\Basket\Controller;

use App\Bundle\Basket\Service\Savage\SavageBasket;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Request;
use Closure;
use TAO;
use Throwable;

class Controller extends TAO\Controller
{
    /**
     * @throws LoaderException
     */
    public function __construct()
    {
        if (!$this->request()->isAjaxRequest()) {
//            $this->redirectTo('/');
        }

        $this->noLayout();
        Loader::includeModule("catalog");
        Loader::includeModule("sale");
    }

    public function get(): void
    {
        $this->try(function () {
            $this->successResponse($this->basket()->toArray());
        });
    }

    public function addCoupon(): void
    {
        $request = $this->jsonFromRequest();
        $coupon = $request['coupon'];

        if (!$coupon) {
            $this->failedResponse([], 'Не передан купон');
        }

        $this->try(function () use ($coupon) {
            $result = $this->basket()->addCoupon($coupon);

            if ($result) {
                $this->basket()->save();

                $this->successResponse([
                    'basket' => $this->basket()->toArray(),
                    'coupon' => $coupon
                ]);
            }

            $this->failedResponse([
                'coupon' => $coupon
            ], 'Ошибка при применении купона');
        });
    }

    public function removeCoupon(): void
    {
        $request = $this->jsonFromRequest();
        $coupon = $request['coupon'];

        if (!$coupon) {
            $this->failedResponse([], 'Не передан купон');
        }

        $this->try(function () use ($coupon) {
            $result = $this->basket()->removeCoupon($coupon);

            if ($result) {
                $this->basket()->save();

                $this->successResponse([
                    'basket' => $this->basket()->toArray(),
                    'coupon' => $coupon
                ]);
            }

            $this->failedResponse([
                'coupon' => $coupon
            ], 'Ошибка при удалении купона');
        });
    }

    public function quantity(string $product_id, string $quantity): void
    {
        $this->try(function ()  use ($product_id, $quantity) {
            $result = $this->basket()->changeItemQuantityByProductId((int) $product_id, (int)$quantity);

            if ($result['result']->isSuccess()) {
                $this->basket()->save();

                $this->successResponse(
                    [
                        'quantity' => $result['item']->quantity,
                        'product_id' => $product_id
                    ],
                    'Успешно измененено количество товара'
                );
            }

            $this->failedResponse(
                ['product_id' => $product_id],
                'Ошика при измененении количества товара',
                $result['result']->getErrorMessages()
            );
        });
    }

    public function add(string $product_id): void
    {
        $this->try(function () use ($product_id) {
            $result = $this->basket()->addProduct((int) $product_id);

            if ($result->isSuccess()) {
                $this->basket()->save();

                $this->successResponse(['product_id' => $product_id], 'Товар успешно добавлен в корзину');
            }

            $this->failedResponse(
                ['product_id' => $product_id],
                'Ошика при добавлении товара в корзину',
                $result->getErrorMessages()
            );
        });
    }

    public function items(): void
    {
        $this->try(function () {
            $items = $this->basket()->getItemsArray();

            $this->successResponse($items);
        });
    }

    public function clear(): void
    {
        $this->try(function () {
            $this->basket()->clear();
            $this->basket()->save();

            $this->successResponse([], 'Корзина очищена');
        });
    }

    public function remove(string $product_id): void
    {
        $this->try(function () use ($product_id) {
            $result = $this->basket()->removeItemByProductId((int)$product_id);

            if ($result->isSuccess()) {
                $this->basket()->save();

                $this->successResponse(['product_id' => $product_id], 'Товар успешно удален из корзины');
            }

            $this->failedResponse(
                ['product_id' => $product_id],
                'Ошика при добавлении товара в корзину',
                $result->getErrorMessages()
            );
        });
    }

    protected function jsonResponse($data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die;
    }

    private function jsonFromRequest()
    {
        return $this->request()->getJsonList()->toArray();
    }

    private function try(Closure $closure, string $message = 'Ошибка при работе с корзиной'): void
    {
        try {
            $closure();
        } catch (Throwable $e) {
            $errors = [];

            if (TAO::isDebugMode()) {
                $errors[] = $e->getMessage();
            }

            $this->failedResponse([], $message, $errors);
        }
    }

    private function failedResponse(mixed $data, string $message = '', array $errors = []): void
    {
        $this->sendResponse(false, $data, $message, $errors);
    }

    private function successResponse(mixed $data, string $message = '', array $errors = []): void
    {
        $this->sendResponse(true, $data, $message, $errors);
    }

    private function sendResponse(bool $success, mixed $data, string $message = '', array $errors = []): void
    {
        $this->jsonResponse([
            'success' => $success,
            'data' => $data,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    private function basket(): SavageBasket
    {
        return SavageBasket::getInstance();
    }

    private function request(): Request|HttpRequest
    {
        return Application::getInstance()->getContext()->getRequest();
    }
}