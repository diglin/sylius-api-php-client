<?php

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;

interface SyliusAdminClientInterface
{
    public function getAddressApi(): Api\Admin\AddressApiInterface;
    public function getAdjustmentApi(): Api\Admin\AdjustmentApiInterface;
    public function getAdministratorApi(): Api\Admin\AdministratorApiInterface;
    public function getAvatarImageApi(): Api\Admin\AvatarImageApiInterface;
    public function getCatalogPromotionTranslationApi(): Api\Admin\CatalogPromotionTranslationApiInterface;
    public function getCatalogPromotionApi(): Api\Admin\CatalogPromotionApiInterface;
    public function getChannelApi(): Api\Admin\ChannelApiInterface;
    public function getShopBillingDataApi(): Api\Admin\ShopBillingDataApiInterface;
    public function getCountryApi(): Api\Admin\CountryApiInterface;
    public function getProvinceApi(): Api\Admin\ProvinceApiInterface;
    public function getCurrencyApi(): Api\Admin\CurrencyApiInterface;
    public function getCustomerGroupApi(): Api\Admin\CustomerGroupApiInterface;
    public function getCustomerApi(): Api\Admin\CustomerApiInterface;
    public function getExchangeRateApi(): Api\Admin\ExchangeRateApiInterface;
    public function getLocaleApi(): Api\Admin\LocaleApiInterface;
    public function getOrderItemUnitApi(): Api\Admin\OrderItemUnitApiInterface;
    public function getOrderItemApi(): Api\Admin\OrderItemApiInterface;
}
