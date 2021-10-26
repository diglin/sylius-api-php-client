<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\DeletableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\UpsertableResourceInterface;

interface AddressApiInterface extends GettableResourceInterface, ListableResourceInterface, CreatableResourceInterface, UpsertableResourceInterface, DeletableResourceInterface
{
}
