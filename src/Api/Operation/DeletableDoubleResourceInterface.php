<?php

namespace Diglin\Sylius\ApiClient\Api\Operation;

use Diglin\Sylius\ApiClient\Exception\HttpException;

interface DeletableDoubleResourceInterface
{
    /**
     * Deletes a resource.
     *
     * @param string|int $parentCode Code of the parent resource
     * @param string|int $code       Code or id of the resource to delete
     *
     * @return int status code 204 indicating that the resource has been well deleted
     *@throws HttpException
     *
     */
    public function delete($parentCode, $code): int;
}
