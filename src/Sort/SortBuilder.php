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

class SortBuilder implements SortBuilderInterface
{
    /** @var \Diglin\Sylius\ApiClient\Sort\SortInterface */
    protected $sort;

    public function __construct(SortInterface $sort)
    {
        $this->sort = $sort;
    }

    public function __invoke()
    {
        return $this->sort->getSorting() ?? [];
    }
}
