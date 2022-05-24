<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Api\Operation\CreatableResourceInterface;

interface ResetPasswordRequestApiInterface extends CreatableResourceInterface
{
    public function acknowledge(string $token): int;
}
