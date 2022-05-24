<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient\Api\Shop;

use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Pagination\PageFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\PageInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;
use Webmozart\Assert\Assert;

final class CustomerApi implements CustomerApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {}

    public function get($code): array
    {
        Assert::integer($code);
        return $this->resourceClient->getResource('api/v2/shop/customers/%d', [$code]);
    }

    public function create($code, array $data = []): int
    {
        Assert::integer($code);
        return $this->resourceClient->createResource('api/v2/shop/customers', [], $data);
    }

    public function upsert($code, array $data = []): int
    {
        Assert::integer($code);
        return $this->resourceClient->upsertResource('api/v2/shop/customers/%d', [$code], $data);
    }

    public function changePassword($code, string $newPassword, string $confirmPassword, string $currentPassword): int
    {
        Assert::integer($code);
        return $this->resourceClient->putResource('api/v2/shop/customers/%d/password', [$code], [
            'newPassword' => $newPassword,
            'confirmNewPassword' => $confirmPassword,
            'currentPassword' => $currentPassword,
        ]);
    }
}
