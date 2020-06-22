<?php

namespace Diglin\Sylius\ApiClient\Api\Operation;

use Diglin\Sylius\ApiClient\Exception\HttpException;

interface GettableDoubleResourceInterface
{
    /**
     * Gets a resource by its code.
     *
     * @param mixed $code code of the parent resource
     * @param mixed $id   code or id of the resource to get
     *
     * @throws HttpException if the request failed
     *
     * @return array
     */
    public function get($code, $id);
}
