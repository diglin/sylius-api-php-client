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

class Sort implements SortInterface
{
    /** @var string */
    private $code;
    /** @var string */
    private $direction;

    public function __construct(string $code, string $direction = SortDirection::DESC)
    {
        $this->code = $code;
        $this->direction = $direction;
    }

    public function getSorting(): array
    {
        return [printf('sorting[%s]', $this->code) => $this->direction];
    }
}
