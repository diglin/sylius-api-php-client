<?php

namespace Diglin\Sylius\ApiClient\Api\Operation;

use Diglin\Sylius\ApiClient\Exception\HttpException;

interface GettableDoubleResourceInterface
{
    /**
     * Gets a resource by its code.
     *
     * @param string|int $code code of the parent resource
     * @param string|int $id   code or id of the resource to get
     *
     * @throws HttpException if the request failed
     */
    public function get($code, $id): array;
}
