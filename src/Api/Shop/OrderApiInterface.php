<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\UpsertableResourceInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;

interface OrderApiInterface extends GettableResourceInterface, ListableResourceInterface, CreatableResourceInterface, UpsertableResourceInterface
{
    /**
     * Lists an order payments.
     *
     * @param string $code Code of the order
     *
     * @throws HttpException if the request failed
     */
    public function listPaymentMethods(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface;

    /**
     * Lists an order shipments.
     *
     * @param string $code Code of the order
     *
     * @throws HttpException if the request failed
     */
    public function listShipmentMethods(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface;
}
