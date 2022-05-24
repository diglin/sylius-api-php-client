<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Webmozart\Assert\Assert;

final class VerifyCustomerAccountApi implements VerifyCustomerAccountApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {}

    public function create($code, array $data = []): int
    {
        Assert::integer($code);
        return $this->resourceClient->createResource('api/v2/shop/account-verification-requests', [], $data);
    }

    public function verify(string $token): int
    {
        return $this->resourceClient->patchResource('api/v2/shop/account-verification-requests/%s', [$token]);
    }
}
