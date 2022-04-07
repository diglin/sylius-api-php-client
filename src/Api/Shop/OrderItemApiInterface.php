<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableDoubleResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\DeletableDoubleResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableDoubleResourceInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\PageInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;

interface OrderItemApiInterface extends GettableResourceInterface, CreatableDoubleResourceInterface, ListableDoubleResourceInterface, DeletableDoubleResourceInterface
{
    public function changeQuantity($parentCode, $code, int $quantity): int;

    /**
     * Gets a list of resources by returning the first page.
     * Consequently, this method does not return all the resources.
     *
     * @param string|int $parentCode Code of the parent resource
     * @param string|int $code       Code of the resource
     * @param int   $limit           The maximum number of resources to return.
     *                               Do note that the server has a maximum limit allowed.
     * @param array $queryParameters additional query parameters to pass in the request
     *
     * @return PageInterface
     *@throws HttpException if the request failed
     *
     */
    public function listAdjustmentsPerPage(
        $parentCode,
        $code,
        int $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): PageInterface;

    /**
     * Gets a cursor to iterate over a list of resources.
     *
     * @param string|int $parentCode      Code of the parent resource
     * @param string|int $code            Code of the resource
     * @param int        $pageSize        The size of the page returned by the server.
     *                                    Do note that the server has a maximum limit allowed.
     * @param array      $queryParameters Additional query parameters to pass in the request
     *
     * @return ResourceCursorInterface
     */
    public function allAdjustments(
        $parentCode,
        $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface;
}
