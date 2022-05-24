<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Webmozart\Assert\Assert;

final class ResetPasswordRequestApi implements ResetPasswordRequestApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {}

    public function create($code, array $data = []): int
    {
        Assert::integer($code);
        return $this->resourceClient->createResource('api/v2/shop/reset-password-requests', [], $data);
    }

    public function verify(string $token): int
    {
        return $this->resourceClient->patchResource('api/v2/shop/reset-password-requests/%s', [$token]);
    }
}
