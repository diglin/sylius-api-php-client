<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;

class SyliusShopClientDecorator implements SyliusShopClientInterface
{
    /** @var list<Api\ApiAwareInterface> */
    private array $apiRegistry = [];

    public function __construct(
        private SyliusShopClientInterface $decoratedClient
    ) {}

    public function __call($name, $arguments)
    {
        $property = lcfirst(substr($name, 3));
        if ('get' === substr($name, 0, 3) && isset($this->apiRegistry[$property])) {
            return $this->apiRegistry[$property];
        }

        return $this->decoratedClient->{$name}($arguments);
    }

    public function addApi(string $key, Api\ApiAwareInterface $api)
    {
        $this->apiRegistry[$key] = $api;
    }

    public function get(string $name): ?Api\ApiAwareInterface
    {
        return $this->apiRegistry[$name] ?? null;
    }

    public function getAddressApi(): Api\Shop\AddressApiInterface
    {
        return $this->decoratedClient->getAddressApi();
    }

    public function getAdjustmentApi(): Api\Shop\AdjustmentApiInterface
    {
        return $this->decoratedClient->getAdjustmentApi();
    }

    public function getChannelApi(): Api\Shop\ChannelApiInterface
    {
        return $this->decoratedClient->getChannelApi();
    }

    public function getCountryApi(): Api\Shop\CountryApiInterface
    {
        return $this->decoratedClient->getCountryApi();
    }
}
