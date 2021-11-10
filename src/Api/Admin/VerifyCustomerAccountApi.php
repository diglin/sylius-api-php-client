<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Admin;

use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Webmozart\Assert\Assert;

final class VerifyCustomerAccountApi implements VerifyCustomerAccountApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {}

    public function create($code, array $data = []): int
    {
        Assert::string($code);
        return $this->resourceClient->createResource('api/v2/admin/account-verification-requests', [], $data);
    }

    public function acknowledge(string $token, string $password, string $confirmation): int
    {
        return $this->resourceClient->patchResource('api/v2/admin/account-verification-requests/%s', [$token], [
            'newPassword' => $password,
            'confirmNewPassword' => $confirmation,
        ]);
    }
}
