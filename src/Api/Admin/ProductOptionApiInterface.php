<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\UpsertableResourceInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;

interface ProductOptionApiInterface extends GettableResourceInterface, ListableResourceInterface, CreatableResourceInterface, UpsertableResourceInterface
{
    /**
     * Lists an option's values.
     *
     * @param string $code Code of the order
     *
     * @throws HttpException if the request failed
     */
    public function listValues(
        string $code,
        int $pageSize = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): ResourceCursorInterface;
}
