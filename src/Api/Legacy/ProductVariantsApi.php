<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 *
 * @category    SyliusApiClient
 *
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\Api\Legacy;

use Diglin\Sylius\ApiClient\Api\ApiAwareTrait;
use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\PageFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\PageInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;

/** @deprecated */
class ProductVariantsApi implements ProductVariantsApiInterface
{
    use ApiAwareTrait;

    public const ENDPOINT_URI = 'api/v1/products/%s/variants/%s';
    public const ENDPOINTS_URI = 'api/v1/products/%s/variants';

    public function __construct(
        ResourceClientInterface $resourceClient,
        PageFactoryInterface $pageFactory,
        ResourceCursorFactoryInterface $cursorFactory
    ) {
        $this->resourceClient = $resourceClient;
        $this->pageFactory = $pageFactory;
        $this->cursorFactory = $cursorFactory;
    }

    public function get($parentCode, $code): array
    {
        return $this->resourceClient->getResource(static::ENDPOINT_URI, [$parentCode, $code]);
    }

    public function create($code, array $data = []): int
    {
        return $this->resourceClient->createResource(static::ENDPOINTS_URI, [$code], $data);
    }

    public function delete($parentCode, $code): int
    {
        return $this->resourceClient->deleteResource(static::ENDPOINT_URI, [$parentCode, $code]);
    }

    public function all(
        $parentCode,
        $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface {
        $firstPage = $this->listPerPage($parentCode, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $firstPage);
    }

    public function listPerPage(
        $parentCode,
        $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface {
        $data = $this->resourceClient->getResources(static::ENDPOINTS_URI, [$parentCode], $limit, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->pageFactory->createPage($data);
    }
}
