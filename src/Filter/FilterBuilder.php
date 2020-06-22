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

class FilterBuilder implements FilterBuilderInterface
{
    /** @var FilterInterface */
    protected $filter;

    public function __construct(FilterInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * API supports only one filter at the moment.
     */
    public function __invoke(): array
    {
        return $this->filter->getCriteria() ?? [];
    }
}
