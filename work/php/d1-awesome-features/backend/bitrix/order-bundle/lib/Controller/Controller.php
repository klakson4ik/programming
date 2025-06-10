<?php

namespace App\Bundle\Order\Controller;

use App\Bundle\Basket\Service\Savage\SavageBasket;
use App\Bundle\Order\Service\Support\Enums\DeliveryType;
use App\Bundle\Order\Service\Support\Location;
use Bitrix\Main\Application;
use App\Bundle\Order\Service\Delivery\DeliveryManager;
use App\Bundle\Order\Service\Order\BaseOrder;
use Bitrix\Main\Config\Option;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Loader;
use Bitrix\Main\Request;
use Closure;
use CUser;
use TAO;
use Throwable;

class Controller extends TAO\Controller
{
    private BaseOrder $order;

    public function __construct()
    {
        Loader::includeModule("catalog");
        Loader::includeModule("sale");

        $this->noLayout();
        $this->order = BaseOrder::getInstance()->create($this->basket()->bitrix_basket);
    }

    public function create(): void
    {
        $this->try(function () {
            $request = $this->jsonFromRequest();

            if (!$request['delivery']) {
                $this->failedResponse($request, 'Не передана служба доставки');
            }

            if (!$request['payment']) {
                $this->failedResponse($request, 'Не передана служба оплаты');
            }

            if (!$request['location']) {
                $this->failedResponse($request, 'Не передан код местоположения');
            }

            $this->order->setLocation($request['location']);

            $deliveries = $this->deliveryManager()->getAvailableDeliveries();
            $current_delivery = 0;
            $delivery_profile = null;

            foreach ($deliveries as $delivery) {
                if ($delivery->id === (int)$request['delivery']) {
                    $this->order->setDelivery($delivery->id, $delivery->name, (float)$request['delivery_price']);
                    $current_delivery = (int)$request['delivery'];
                    $delivery_profile = $this->deliveryManager()->getProviderById($current_delivery);
                    break;
                }
            }

            if (!$current_delivery) {
                $this->failedResponse(['delivery_id' => $request['delivery']], 'Ошибки при установке службы доставки');
            }

            $payments = $this->order->getAvailablePaySystems();
            $current_payment = 0;

            foreach ($payments as $payment) {
                if ($payment->pay_system_id === (int)$request['payment']) {
                    $this->order->setPayment($payment->pay_system_id, $payment->name);
                    $current_payment = (int)$payment;
                    break;
                }
            }

            if (!$current_payment) {
                $this->failedResponse(['payment_id' => $request['payment']], 'Ошибки при установке службы оплаты');
            }

            $request_data = $delivery_profile->getPropsByRequest($request, $current_delivery);
            $request = $request_data['request'];

            if ($request_data['errors']) {
                $this->failedResponse($request, 'Ошибка при проверке необходимых полей');
            }

            $request = array_combine(array_keys($request), array_column($request, 'value'));
            $this->order->setPropertiesByArray($request);

            $user_id = $this->getUserId();

            if ($user_id === 0) {
                $this->failedResponse($request, 'Ошибка при получении id пользователя');
            }

            $this->order->setUser($user_id);
            $this->order->applyDiscount();

            $this->order->doFinalAction();
            $save_result = $this->order->save();

            if (!$save_result->isSuccess()) {
                $this->failedResponse(array_merge($this->jsonFromRequest()), 'Ошибка при сохранении заказа', $save_result->getErrorMessages());
            }

            $this->successResponse([
                'order_id' => $this->order->getId()
            ], 'Заказ успешно создан');
        }, 'Ошибка при создании заказа');
    }

    public function index(): void
    {
        $this->try(function () {
            $request = $this->jsonFromRequest();

            if ($request['location']) {
                $this->order->setLocation($request['location']);
            }

            $deliveries = $this->deliveryManager()->getAvailableDeliveries();

            if ($request['delivery']) {
                foreach ($deliveries as $delivery) {
                    if ($delivery->id === (int)$request['delivery']) {
                        $this->order->setDelivery($delivery->id, $delivery->name, (float)$request['delivery_price']);
                    }
                }
            }

            $payments = $this->order->getAvailablePaySystems();

            if ($request['payment']) {
                foreach ($payments as $payment) {
                    if ($payment->pay_system_id === (int)$request['payment']) {
                        $this->order->setPayment($payment->pay_system_id, $payment->name);
                    }
                }
            }

            foreach ($this->order->getPropertyCollection() as $property) {
                $code = strtolower($property->getField('CODE'));

                if (in_array($code, array_keys($request)) && !empty($request[$code])) {
                    $property->setValue($request[$code]);
                }
            }

            $this->successResponse([
                'items' => $this->basket()->getItemsArray(),
                'order' => [
                    'prices' => [
                        'price' => round($this->order->getPrice(), 2),
                        'base' => round($this->order->getBasePrice(), 2),
                        'delivery' => round($this->order->getDeliveryPrice(), 2),
                        'discount' => round($this->order->getDiscountPrice(), 2),
                    ],
                    'selected_delivery' => $this->order->getSelectedDeliveryId(),
                    'selected_payment' => $this->order->getSelectedPaySystemId(),
                    'zip' => $this->order->getZip(),
                    'location' => $this->order->getLocation(),
                    'fields' => $this->order->getFieldsArray()
                ],
                'deliveries' => $deliveries,
                'payments' => $payments
            ], 'Данные заказа успешно обновленны');
        });
    }

    public function getPickupPoints(): void
    {
        $this->try(function () {
            $data = $this->jsonFromRequest();
            $this->order->setLocation($data['location']);

            foreach ($this->order->getPropertyCollection() as $property) {
                if ($property->getField('CODE') === 'ZIP') {
                    $this->order->setZip($data['zip']);
                }
            }

            $provider = $this->deliveryManager()->getProviderByName($data['provider']);
            $profile_data = $provider->getProfileData(['id' => $data['id'], 'type' => DeliveryType::PICKUP], true);

            if (!empty($profile_data->points)) {
                $this->successResponse($profile_data, 'Успешно получены данные службы доставки ' . $data['provider']);
            }

            $this->failedResponse($data, 'Ошибка при получении данных службы доставки');
        });
    }

    public function getLocation(): void
    {
        $this->try(function () {
            $data = $this->jsonFromRequest();

            if (!$data['zip']) {
                $this->failedResponse([], 'Не передан почтоый индекс');
            }

            $location = Location::new($data['zip'], $data['region'], $data['city'])->getCode();

            if ($location) {
                $this->successResponse(['location_code' => $location]);
            }

            $this->failedResponse($this->jsonFromRequest(), 'Не удалось найти код местоположения');
        });
    }

    protected function jsonResponse($data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die;
    }

    private function getUserId(): int
    {
        global $USER;

        if ($USER->IsAuthorized()) {
            return (int)$USER->GetID();
        }

        return (int)$USER->Add($this->getNewUserFields());
    }

    private function getNewUserFields(): array
    {
        $request = $this->jsonFromRequest();

        $default_groups = Option::get('main', 'new_user_registration_def_group', '');
        $user_groups = [];

        if (!empty($default_groups)) {
            $user_groups = explode(',', $default_groups);
        }

        $password = CUser::GeneratePasswordByPolicy($user_groups);

        return [
            'LOGIN' => $request['email'],
            'NAME' => $request['name'],
            'PASSWORD' => $password,
            'CONFIRM_PASSWORD' => $password,
            'EMAIL' => $request['email'],
            'GROUP_ID' => $user_groups,
            'ACTIVE' => 'Y',
            'LID' => SITE_ID,
            'PERSONAL_PHONE' => preg_replace('/[^0-9]/', '', $request['phone']),
        ];
    }

    private function basket(): SavageBasket
    {
        return SavageBasket::getInstance();
    }

    private function getValidatedRequest(): array
    {
        $errors = false;

        $request['location'] = $this->validateRequestKey('location', 'Не указан город');
        $request['email'] = $this->validateRequestKey('email', 'Не указан email');
        $request['name'] = $this->validateRequestKey('name', 'Не указано имя');
        $request['phone'] = $this->validateRequestKey('phone', 'Не указан телефон');
        $request['address'] = $this->validateRequestKey('address', 'Не указан адрес');
        $request['delivery'] = $this->validateRequestKey('delivery', 'Не указана служба доставки');
        $request['payment'] = $this->validateRequestKey('payment', 'Не указана служба оплаты');

        foreach ($request as $field) {
            if ($field['error']) {
                $errors = true;
                break;
            }
        }

        return [
            'request' => $request,
            'errors' => $errors
        ];
    }

    private function validateRequestKey($key, $message): array
    {
        $request = $this->jsonFromRequest();

        return [
            'value' => $request[$key],
            'error' => !$request[$key],
            'message' => $request[$key] ? '' : $message
        ];
    }

    private function jsonFromRequest()
    {
        return $this->request()->getJsonList()->toArray();
    }

    private function try(Closure $closure, string $message = 'Ошибка при работе с заказом'): void
    {
        try {
            $closure();
        } catch (Throwable $e) {
            $errors = [];

            if (TAO::isDebugMode()) {
                $errors[] = $e->getMessage();
                $errors = array_merge($errors, $e->getTrace());
            }

            $this->failedResponse([],$message, $errors);
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

    private function request(): Request|HttpRequest
    {
        return Application::getInstance()->getContext()->getRequest();
    }

    private function deliveryManager(): DeliveryManager
    {
        return DeliveryManager::getInstance($this->order->bitrix_order);
    }
}