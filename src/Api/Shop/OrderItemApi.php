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

final class OrderItemApi implements OrderItemApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
        private PageFactoryInterface $pageFactory,
        private ResourceCursorFactoryInterface $cursorFactory,
    ) {}

    public function get($code): array
    {
        Assert::integer($code);
        return $this->resourceClient->getResource('api/v2/shop/order-items/%d', [$code]);
    }

    public function listPerPage(
        $parentCode,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        Assert::integer($parentCode);
        $data = $this->resourceClient->getResources('api/v2/shop/orders/%d/items', [$parentCode], $limit, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->pageFactory->createPage($data);
    }

    public function all(
        $parentCode,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->listPerPage($parentCode, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $data);
    }

    public function create($parentCode, $code, array $data = []): int
    {
        Assert::integer($parentCode);
        Assert::integer($code);
        return $this->resourceClient->createResource('api/v2/shop/orders/%d/items', [$parentCode], $data);
    }

    public function delete($parentCode, $code): int
    {
        Assert::integer($parentCode);
        Assert::integer($code);
        return $this->resourceClient->deleteResource('api/v2/shop/orders/%1$d/items/%2$d', [$parentCode, $code]);
    }

    public function changeQuantity($parentCode, $code, int $quantity): int
    {
        return $this->resourceClient->patchResource('api/v2/shop/orders/%1$d/items/%2%d', [$parentCode, $code], [
            'quantity' => $quantity,
        ]);
    }

    public function listAdjustmentsPerPage(
        $parentCode,
        $code,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        Assert::string($parentCode);
        $data = $this->resourceClient->getResources('api/v2/shop/orders/%1$s/items/%1$d/adjustments', [$parentCode, $code]);

        return $this->pageFactory->createPage($data);
    }

    public function allAdjustments(
        $parentCode,
        $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->listAdjustmentsPerPage($parentCode, $code, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $data);
    }
}
