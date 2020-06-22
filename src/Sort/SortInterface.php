<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 *
 * @category    FWG OroCRM
 *
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\Sort;

interface SortInterface
{
    public function __construct(string $code, string $direction = SortDirection::DESC);

    public function getSorting(): array;
}
