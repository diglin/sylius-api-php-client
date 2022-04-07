<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\UpsertableResourceInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\PageInterface;
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
    public function listPaymentMethodsPerPage(
        string $code,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface;

    public function allPaymentMethods(
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
    public function listShipmentMethodsPerPage(
        string $code,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface;

    public function allShipmentMethods(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface;

    public function listAdjustmentsPerPage(
        string $code,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface;

    public function allAdjustments(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface;

    public function listItemsPerPage(
        string $code,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface;

    public function allItems(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface;

    /**
     * Lists an order shipments.
     *
     * @param string $code           Code of the order
     * @param string $paymentId      Id of the payment
     * @param string $shippingMethod The chosen payment method
     *
     * @throws HttpException if the request failed
     */
    public function choosePayment(string $code, string $paymentId, string $paymentMethod): int;

    /**
     * Lists an order shipments.
     *
     * @param string $code           Code of the order
     * @param string $shipmentId     Id of the shipment
     * @param string $shippingMethod The chosen shipment method
     *
     * @throws HttpException if the request failed
     */
    public function chooseShipment(string $code, string $shipmentId, string $shippingMethod): int;

    /**
     * Lists an order shipments.
     *
     * @param string $code  Code of the order
     * @param string $notes Notes to add to the order
     *
     * @returns 200 if the request has succeeded
     *
     * @throws HttpException if the request failed
     */
    public function complete(string $code, string $notes): int;
}
