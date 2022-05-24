<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\GettableResourceInterface;
use Diglin\Sylius\ApiClient\Api\Operation\UpsertableResourceInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;

interface CustomerApiInterface extends GettableResourceInterface, CreatableResourceInterface, UpsertableResourceInterface
{
    /**
     * Changes the current customer's password.
     *
     * @param string|int $code Code of the resource
     * @param string $newPassword The new password
     * @param string $confirmPassword Confirmation of the new password
     * @param string $currentPassword The current password, before the change
     *
     * @throws HttpException if the request failed
     *
     * @return int status code 204 indicating that the password has been well updated.
     */
    public function changePassword($code, string $newPassword, string $confirmPassword, string $currentPassword): int;
}
