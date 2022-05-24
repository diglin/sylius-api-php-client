<?php

namespace Diglin\Sylius\ApiClient\Api\Operation;

use Diglin\Sylius\ApiClient\Exception\HttpException;
use Diglin\Sylius\ApiClient\Exception\InvalidArgumentException;

interface CreatableDoubleResourceInterface
{
    /**
     * Creates a resource.
     *
     * @param string|int $parentCode Code of the parent resource
     * @param string|int $code code of the resource to create
     * @param array      $data data of the resource to create
     *
     * @throws HttpException            if the request failed
     * @throws InvalidArgumentException if the parameter "code" is defined in the data parameter
     *
     * @return int status code 201 indicating that the resource has been well created
     */
    public function create($parentCode, $code, array $data = []): int;
}
