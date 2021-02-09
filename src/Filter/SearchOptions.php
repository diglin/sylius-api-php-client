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

namespace Diglin\Sylius\ApiClient\Filter;

final class SearchOptions
{
    public const CONTAINS = 'contains';
    public const NOT_CONTAINS = 'not_contains';
    public const EQUAL = 'equal';
    public const NOT_EQUAL = 'not_equal';
    public const STARTS_WITH = 'starts_with';
    public const ENDS_WITH = 'ends_with';
    public const EMPTY = 'empty';
    public const NOT_EMPTY = 'not_empty';
    public const IN = 'in';
    public const NOT_IN = 'not_in';
}
