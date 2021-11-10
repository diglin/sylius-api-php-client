<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;

interface PaymentApiInterface extends GettableResourceInterface, ListableResourceInterface
{
    /**
     * Cancel an order.
     *
     * @param string $code Code of the order
     *
     * @throws HttpException if the request failed
     */
    public function complete(string $code, array $data = []): int;
}
