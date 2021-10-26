<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;

class SyliusAdminClientDecorator implements SyliusAdminClientInterface
{
    /** @var list<Api\ApiAwareInterface> */
    private array $apiRegistry = [];

    public function __construct(
        private SyliusAdminClientInterface $decoratedClient
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

    public function getAddressApi(): Api\Admin\AddressApiInterface
    {
        return $this->decoratedClient->getAddressApi();
    }

    public function getAdjustmentApi(): Api\Admin\AdjustmentApiInterface
    {
        return $this->decoratedClient->getAdjustmentApi();
    }

    public function getAdministratorApi(): Api\Admin\AdministratorApiInterface
    {
        return $this->decoratedClient->getAdministratorApi();
    }

    public function getAvatarImageApi(): Api\Admin\AvatarImageApiInterface
    {
        return $this->decoratedClient->getAvatarImageApi();
    }

    public function getCatalogPromotionTranslationApi(): Api\Admin\CatalogPromotionTranslationApiInterface
    {
        return $this->decoratedClient->getCatalogPromotionTranslationApi();
    }

    public function getCatalogPromotionApi(): Api\Admin\CatalogPromotionApiInterface
    {
        return $this->decoratedClient->getCatalogPromotionApi();
    }

    public function getChannelApi(): Api\Admin\ChannelApiInterface
    {
        return $this->decoratedClient->getChannelApi();
    }

    public function getShopBillingDataApi(): Api\Admin\ShopBillingDataApiInterface
    {
        return $this->decoratedClient->getShopBillingDataApi();
    }

    public function getCountryApi(): Api\Admin\CountryApiInterface
    {
        return $this->decoratedClient->getCountryApi();
    }

    public function getProvinceApi(): Api\Admin\ProvinceApiInterface
    {
        return $this->decoratedClient->getProvinceApi();
    }

    public function getCurrencyApi(): Api\Admin\CurrencyApiInterface
    {
        return $this->decoratedClient->getCurrencyApi();
    }
}
