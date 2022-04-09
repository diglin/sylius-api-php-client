<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Webmozart\Assert\Assert;

final class ProductOptionApi implements ProductOptionApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {}

    public function get($code): array
    {
        Assert::string($code);
        return $this->resourceClient->getResource('api/v2/shop/product-options/%s', [$code]);
    }
}
