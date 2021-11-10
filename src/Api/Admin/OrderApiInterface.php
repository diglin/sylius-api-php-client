<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;

interface OrderApiInterface extends GettableResourceInterface, ListableResourceInterface
{
    /**
     * Cancel an order.
     *
     * @param string $code Code of the order
     *
     * @throws HttpException if the request failed
     */
    public function cancel(string $code, array $data = []): int;

    /**
     * Lists an order payments.
     *
     * @param string $code Code of the order
     *
     * @throws HttpException if the request failed
     */
    public function listPayments(
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
    public function listShipments(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface;
}
