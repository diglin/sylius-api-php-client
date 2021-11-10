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

final class ProductOptionApi implements ProductOptionApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
        private PageFactoryInterface $pageFactory,
        private ResourceCursorFactoryInterface $cursorFactory,
    ) {}

    public function get($code): array
    {
        Assert::string($code);
        return $this->resourceClient->getResource('api/v2/admin/product-options/%s', [$code]);
    }

    public function create($code, array $data = []): int
    {
        Assert::string($code);
        return $this->resourceClient->createResource('api/v2/admin/product-options', [], $data);
    }

    public function listPerPage(
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        $data = $this->resourceClient->getResources('api/v2/admin/product-options', [], $limit, $queryParameters, $filterBuilder, $sortBuilder);

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

    public function upsert($code, array $data = []): int
    {
        Assert::string($code);
        return $this->resourceClient->upsertResource('api/v2/admin/product-options/%s', [$code], $data);
    }

    public function listValues(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        Assert::string($code);
        $data = $this->resourceClient->getResources('api/v2/admin/product-options/%s/values', [$code], $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $this->pageFactory->createPage($data));
    }
}
