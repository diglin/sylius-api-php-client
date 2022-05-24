<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Api\Operation\DeletableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\UpsertableResourceInterface;

interface ProductReviewApiInterface extends GettableResourceInterface, ListableResourceInterface, UpsertableResourceInterface, DeletableResourceInterface
{
    public function accept(string $code, array $data = []): int;
    public function reject(string $code, array $data = []): int;
}
