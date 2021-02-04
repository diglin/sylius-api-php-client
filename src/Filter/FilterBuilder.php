<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    SyliusApiClient
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\Filter;

class FilterBuilder implements FilterBuilderInterface
{
    /** @var FilterInterface */
    protected $filter;

    public function __construct(FilterInterface ...$filters)
    {
        $this->filters = $filters;
    }

    public function __invoke(): array
    {
        $criteria = [];
        foreach ($this->filters as $filter) {
            $criteria = array_merge($criteria, $filter->getCriteria());
        }
        return $criteria;
    }
}
