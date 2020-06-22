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

class PromotionCouponsApi implements PromotionCouponsApiInterface
{
    use ApiAwareTrait;

    public const ENDPOINT_URI = 'api/v1/promotions/%s/coupons/%s';
    public const ENDPOINTS_URI = 'api/v1/promotions/%s/coupons';

    public function __construct(
        ResourceClientInterface $resourceClient,
        PageFactoryInterface $pageFactory,
        ResourceCursorFactoryInterface $cursorFactory
    ) {
        $this->resourceClient = $resourceClient;
        $this->pageFactory = $pageFactory;
        $this->cursorFactory = $cursorFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get($promotionCode, $couponCode)
    {
        return $this->resourceClient->getResource(static::ENDPOINT_URI, [$promotionCode, $couponCode]);
    }

    /**
     * {@inheritdoc}
     */
    public function create($code, array $data = [])
    {
        return $this->resourceClient->createResource(static::ENDPOINTS_URI, [$code], $data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($promotionCode, $couponCode)
    {
        return $this->resourceClient->deleteResource(static::ENDPOINT_URI, [$promotionCode, $couponCode]);
    }

    /**
     * {@inheritdoc}
     */
    public function all(
        string $promotionCode,
        $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ) {
        $firstPage = $this->listPerPage($promotionCode, $pageSize, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->cursorFactory->createCursor($pageSize, $firstPage);
    }

    /**
     * {@inheritdoc}
     */
    public function listPerPage(
        string $promotionCode,
        $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ) {
        $data = $this->resourceClient->getResources(static::ENDPOINTS_URI, [$promotionCode], $limit, $queryParameters, $filterBuilder, $sortBuilder);

        return $this->pageFactory->createPage($data);
    }
}
