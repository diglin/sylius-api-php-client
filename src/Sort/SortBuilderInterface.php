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

interface SortBuilderInterface
{
    public function __construct(SortInterface $sort);

    public function __invoke();
}
