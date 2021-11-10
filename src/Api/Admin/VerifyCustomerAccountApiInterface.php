<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableResourceInterface;

interface VerifyCustomerAccountApiInterface extends CreatableResourceInterface
{
    public function acknowledge(string $token, string $password, string $confirmation): int;
}
