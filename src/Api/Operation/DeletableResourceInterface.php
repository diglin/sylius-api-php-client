<?php

namespace Diglin\Sylius\ApiClient\Api\Operation;

use Diglin\Sylius\ApiClient\Exception\HttpException;

/**
 * API that can delete a resource.
 *
 * @author    Laurent Petard <laurent.petard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface DeletableResourceInterface
{
    /**
     * Deletes a resource.
     *
     * @param mixed $code code or id of the resource to delete
     *
     * @throws HttpException
     *
     * @return int status code 204 indicating that the resource has been well deleted
     */
    public function delete($code);
}
