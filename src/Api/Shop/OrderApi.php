<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\PageFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\PageInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;
use Webmozart\Assert\Assert;

final class OrderApi implements OrderApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
        private PageFactoryInterface $pageFactory,
        private ResourceCursorFactoryInterface $cursorFactory,
    ) {}

    public function get($code): array
    {
        Assert::integer($code);
        return $this->resourceClient->getResource('api/v2/shop/orders/%d', [$code]);
    }

    public function listPerPage(
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        $data = $this->resourceClient->getResources('api/v2/shop/orders', [], $limit, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->pageFactory->createPage($data);
    }

    public function all(
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->listPerPage($pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $data);
    }

    public function create($code, array $data = []): int
    {
        Assert::integer($code);
        return $this->resourceClient->createResource('api/v2/shop/orders', [], $data);
    }

    public function upsert($code, array $data = []): int
    {
        Assert::integer($code);
        return $this->resourceClient->upsertResource('api/v2/shop/orders/%d', [$code]);
    }

    public function listPaymentMethodsPerPage(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        $data = $this->resourceClient->getResources('api/v2/shop/shipping-methods/%s', [$code], $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->pageFactory->createPage($data);
    }

    public function allPaymentMethods(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->listPaymentMethodsPerPage($code, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $data);
    }

    public function listShipmentMethodsPerPage(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        $data = $this->resourceClient->getResources('api/v2/shop/shipping-methods/%s', [$code], $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->pageFactory->createPage($data);
    }

    public function allShipmentMethods(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->listShipmentMethodsPerPage($code, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $data);
    }

    public function listAdjustmentsPerPage(
        $code,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        Assert::string($code);
        $data = $this->resourceClient->getResources('api/v2/shop/orders/%s/adjustments', [$code]);

        return $this->pageFactory->createPage($data);
    }

    public function allAdjustments(
        $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->listAdjustmentsPerPage($code, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $data);
    }

    public function listItemsPerPage(
        $code,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        Assert::string($code);
        $data = $this->resourceClient->getResources('api/v2/shop/orders/%s/items', [$code]);

        return $this->pageFactory->createPage($data);
    }

    public function allItems(
        $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->listItemsPerPage($code, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $data);
    }

    public function choosePayment(string $code, string $paymentId, string $paymentMethod): int
    {
        Assert::string($code);
        Assert::string($paymentId);
        return $this->resourceClient->patchResource('api/v2/shop/orders/%1$s/payments/%2$s', [$code, $paymentId], [
            'paymentMethod' => $paymentMethod,
        ]);
    }

    public function chooseShipment(string $code, string $shipmentId, string $shippingMethod): int
    {
        Assert::string($code);
        Assert::string($shipmentId);
        return $this->resourceClient->patchResource('api/v2/shop/orders/%1$s/shipments/%2$s', [$code, $shipmentId], [
            'shippingMethod' => $shippingMethod,
        ]);
    }

    public function complete(string $code, string $notes): int
    {
        Assert::string($code);
        return $this->resourceClient->patchResource('api/v2/shop/orders/%s/complete', [$code], [
            'notes' => $notes,
        ]);
    }
}
