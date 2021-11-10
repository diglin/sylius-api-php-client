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

final class ShippingCategoryApi implements ShippingCategoryApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
        private PageFactoryInterface $pageFactory,
        private ResourceCursorFactoryInterface $cursorFactory,
    ) {}

    public function get($code): array
    {
        Assert::string($code);
        return $this->resourceClient->getResource('api/v2/admin/shipping-categories/%s', [$code]);
    }

    public function upsert($code, array $data = []): int
    {
        Assert::string($code);
        return $this->resourceClient->upsertResource('api/v2/admin/shipping-categories/%s', [$code]);
    }

    public function listPerPage(
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        $data = $this->resourceClient->getResources('api/v2/admin/shipping-categories', [], $limit, $queryParameters, $filterBuilder, $sortBuilder);

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
        Assert::string($code);
        return $this->resourceClient->createResource('api/v2/admin/shipping-categories', [], $data);
    }

    public function delete($code): int
    {
        Assert::string($code);
        return $this->resourceClient->deleteResource('api/v2/admin/shipping-categories/%s', [$code]);
    }
}
