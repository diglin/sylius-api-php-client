<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableDoubleResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\UpsertableResourceInterface;

interface ProvinceApiInterface extends GettableResourceInterface, ListableDoubleResourceInterface, UpsertableResourceInterface
{
}
