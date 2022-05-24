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
    public function getOrderApi(): Api\Admin\OrderApiInterface;
    public function getPaymentApi(): Api\Admin\PaymentApiInterface;
    public function getShipmentApi(): Api\Admin\ShipmentApiInterface;
    public function getPaymentMethodApi(): Api\Admin\PaymentMethodApiInterface;
    public function getProductAssociationTypeTranslationApi(): Api\Admin\ProductAssociationTypeTranslationApiInterface;
    public function getProductAssociationTypeApi(): Api\Admin\ProductAssociationTypeApiInterface;
    public function getProductImageApi(): Api\Admin\ProductImageApiInterface;
    public function getProductOptionTranslationApi(): Api\Admin\ProductOptionTranslationApiInterface;
    public function getProductOptionValueApi(): Api\Admin\ProductOptionValueApiInterface;
    public function getProductOptionApi(): Api\Admin\ProductOptionApiInterface;
    public function getProductReviewApi(): Api\Admin\ProductReviewApiInterface;
    public function getProductTaxonApi(): Api\Admin\ProductTaxonApiInterface;
    public function getProductTranslationApi(): Api\Admin\ProductTranslationApiInterface;
    public function getProductVariantTranslationApi(): Api\Admin\ProductVariantTranslationApiInterface;
    public function getProductVariantApi(): Api\Admin\ProductVariantApiInterface;
    public function getProductApi(): Api\Admin\ProductApiInterface;
    public function getPromotionApi(): Api\Admin\PromotionApiInterface;
    public function getShippingCategoryApi(): Api\Admin\ShippingCategoryApiInterface;
    public function getShippingMethodTranslationApi(): Api\Admin\ShippingMethodTranslationApiInterface;
    public function getShippingMethodApi(): Api\Admin\ShippingMethodApiInterface;
    public function getTaxCategoryApi(): Api\Admin\TaxCategoryApiInterface;
    public function getTaxonTranslationApi(): Api\Admin\TaxonTranslationApiInterface;
    public function getTaxonApi(): Api\Admin\TaxonApiInterface;
    public function getZoneMemberApi(): Api\Admin\ZoneMemberApiInterface;
    public function getZoneApi(): Api\Admin\ZoneApiInterface;
    public function getVerifyCustomerAccountApi(): Api\Admin\VerifyCustomerAccountApiInterface;
    public function getResetPasswordRequestApi(): Api\Admin\ResetPasswordRequestApiInterface;
}
