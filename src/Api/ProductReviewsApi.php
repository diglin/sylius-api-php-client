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

namespace Diglin\Sylius\ApiClient\Api;

use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\PageFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactoryInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;

class ProductReviewsApi implements ProductReviewsApiInterface
{
    use ApiAwareTrait;

    public const ENDPOINT_URI = 'api/v1/products/%s/reviews/%d';
    public const ENDPOINTS_URI = 'api/v1/products/%s/reviews';

    public function __construct(
        ResourceClientInterface $resourceClient,
        PageFactoryInterface $pageFactory,
        ResourceCursorFactoryInterface $cursorFactory
    ) {
        $this->resourceClient = $resourceClient;
        $this->pageFactory = $pageFactory;
        $this->cursorFactory = $cursorFactory;
    }

    public function get($productCode, $id)
    {
        return $this->resourceClient->getResource(static::ENDPOINT_URI, [$productCode, $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function create($productCode, array $data = [])
    {
        return $this->resourceClient->createResource(static::ENDPOINTS_URI, [$productCode], $data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($productCode, $id)
    {
        return $this->resourceClient->deleteResource(static::ENDPOINT_URI, [$productCode, $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function all(
        string $productCode,
        $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ) {
        $firstPage = $this->listPerPage($productCode, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $firstPage);
    }

    /**
     * {@inheritdoc}
     */
    public function listPerPage(
        string $productCode,
        $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ) {
        $data = $this->resourceClient->getResources(static::ENDPOINTS_URI, [$productCode], $limit, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->pageFactory->createPage($data);
    }
}
