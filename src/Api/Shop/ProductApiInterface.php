<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;

interface ProductApiInterface extends GettableResourceInterface, ListableResourceInterface
{
    /**
     * Gets a resource by its slug.
     *
     * @param string $slug Slug of the resource
     *
     * @throws HttpException if the request failed
     */
    public function getBySlug(string $slug): array;
}
