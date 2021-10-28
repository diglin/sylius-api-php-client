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

use Diglin\Sylius\ApiClient\Api\ApiAwareInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\ListableResourceInterface;

/** @deprecated */
interface ShippingCategoriesApiInterface extends ApiAwareInterface, GettableResourceInterface, ListableResourceInterface
{
}
