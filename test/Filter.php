<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    SyliusApiClient
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\Test;

use Diglin\Sylius\ApiClient\Filter\FilterBuilder;
use Diglin\Sylius\ApiClient\Routing\UriGenerator;
use PHPUnit\Framework\TestCase;

class Filter extends TestCase
{
    public function testFilter()
    {
        $criteria = (new \Diglin\Sylius\ApiClient\Filter\Filter('channel', 1))->getCriteria();
        $this->assertArrayHasKey('criteria[channel]', $criteria);

        $criteria = (new \Diglin\Sylius\ApiClient\Filter\Filter(['date'=> ['from' => ['date' => '2021-02-04']]]))->getCriteria();
        $this->assertArrayHasKey('criteria[date][from][date]', $criteria);
        $this->assertEquals('2021-02-04', $criteria['criteria[date][from][date]']);
    }

    public function testFilterBuilder()
    {
        $builder = (new FilterBuilder(
            new \Diglin\Sylius\ApiClient\Filter\Filter('channel', 1),
            new \Diglin\Sylius\ApiClient\Filter\Filter(['date'=> ['from' => ['date' => '2021-02-04']]])
        ));

        $criteria = $builder();
        $this->assertCount(2, $criteria);
    }
}
