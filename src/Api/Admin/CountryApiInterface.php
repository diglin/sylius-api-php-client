<?php

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\DeletableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;

interface CountryApiInterface extends GettableResourceInterface, CreatableResourceInterface, ListableResourceInterface, DeletableResourceInterface
{
}
