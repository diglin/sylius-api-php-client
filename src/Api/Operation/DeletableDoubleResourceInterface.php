<?php

namespace Diglin\Sylius\ApiClient\Api\Operation;

use Diglin\Sylius\ApiClient\Exception\HttpException;

interface DeletableDoubleResourceInterface
{
    /**
     * Deletes a resource.
     *
     * @param string|int $code code of the parent resource
     * @param string|int $id   code or id of the resource to get
     *
     * @throws HttpException
     *
     * @return int status code 204 indicating that the resource has been well deleted
     */
    public function delete($code, string|int $id): int;
}
