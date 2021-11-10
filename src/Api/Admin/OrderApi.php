<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

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
        Assert::string($code);
        return $this->resourceClient->getResource('api/v2/admin/orders/%s', [$code]);
    }

    public function listPerPage(
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        $data = $this->resourceClient->getResources('api/v2/admin/orders', [], $limit, $queryParameters, $filterBuilder, $sortBuilder);

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

    public function cancel(string $code, array $data = []): int
    {
        Assert::string($code);
        return $this->resourceClient->patchResource('api/v2/admin/orders/%s/cancel', [$code], $data);
    }

    public function listPayments(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->resourceClient->getResources('api/v2/admin/orders/%s/payments', [], $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $this->pageFactory->createPage($data));
    }

    public function listShipments(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $data = $this->resourceClient->getResources('api/v2/admin/orders/%s/shipments', [], $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $this->pageFactory->createPage($data));
    }
}
