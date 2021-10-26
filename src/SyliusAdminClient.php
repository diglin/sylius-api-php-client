<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;
use Diglin\Sylius\ApiClient\Security\Authentication;

class SyliusAdminClient implements SyliusAdminClientInterface
{
    public function __construct(
        private Authentication $authentication,
        private Api\Admin\AddressApiInterface $addressApi,
        private Api\Admin\AdjustmentApiInterface $adjustmentApi,
        private Api\Admin\AdministratorApiInterface $administratorApi,
        private Api\Admin\AvatarImageApiInterface $avatarImageApi,
        private Api\Admin\CatalogPromotionTranslationApiInterface $catalogPromotionTranslationApi,
        private Api\Admin\CatalogPromotionApiInterface $catalogPromotionApi,
        private Api\Admin\ChannelApiInterface $channelApi,
        private Api\Admin\ShopBillingDataApiInterface $shopBillingDataApi,
        private Api\Admin\CountryApiInterface $countryApi,
        private Api\Admin\ProvinceApiInterface $provinceApi,
        private Api\Admin\CurrencyApiInterface $currencyApi,
    ) {}

    public function getAddressApi(): Api\Admin\AddressApiInterface
    {
        return $this->addressApi;
    }

    public function getAdjustmentApi(): Api\Admin\AdjustmentApiInterface
    {
        return $this->adjustmentApi;
    }

    public function getAdministratorApi(): Api\Admin\AdministratorApiInterface
    {
        return $this->administratorApi;
    }

    public function getAvatarImageApi(): Api\Admin\AvatarImageApiInterface
    {
        return $this->avatarImageApi;
    }

    public function getCatalogPromotionTranslationApi(): Api\Admin\CatalogPromotionTranslationApiInterface
    {
        return $this->catalogPromotionTranslationApi;
    }

    public function getCatalogPromotionApi(): Api\Admin\CatalogPromotionApiInterface
    {
        return $this->catalogPromotionApi;
    }

    public function getChannelApi(): Api\Admin\ChannelApiInterface
    {
        return $this->channelApi;
    }

    public function getShopBillingDataApi(): Api\Admin\ShopBillingDataApiInterface
    {
        return $this->shopBillingDataApi;
    }

    public function getCountryApi(): Api\Admin\CountryApiInterface
    {
        return $this->countryApi;
    }

    public function getProvinceApi(): Api\Admin\ProvinceApiInterface
    {
        return $this->provinceApi;
    }

    public function getCurrencyApi(): Api\Admin\CurrencyApiInterface
    {
        return $this->currencyApi;
    }
}
