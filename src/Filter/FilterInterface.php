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

/**
 * Interface FilterInterface.
 */
interface FilterInterface
{
    public function __construct(
        string $nameOfCriterion = 'search',
        string $searchOption = SearchOptions::CONTAINS,
        string $searchPhrase = ''
    );

    public function getCriteria(): array;
}
