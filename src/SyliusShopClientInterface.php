<?php

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;

interface SyliusShopClientInterface
{
    public function getAddressApi(): Api\Shop\AddressApiInterface;
    public function getAdjustmentApi(): Api\Shop\AdjustmentApiInterface;
    public function getCatalogPromotionApi(): Api\Shop\CatalogPromotionApiInterface;
    public function getChannelApi(): Api\Shop\ChannelApiInterface;
    public function getCountryApi(): Api\Shop\CountryApiInterface;
    public function getCurrencyApi(): Api\Shop\CurrencyApiInterface;
    public function getCustomerApi(): Api\Shop\CustomerApiInterface;
    public function getLocaleApi(): Api\Shop\LocaleApiInterface;
    public function getOrderItemUnitApi(): Api\Shop\OrderItemUnitApiInterface;
    public function getOrderItemApi(): Api\Shop\OrderItemApiInterface;
    public function getOrderApi(): Api\Shop\OrderApiInterface;
    public function getPaymentApi(): Api\Shop\PaymentApiInterface;
    public function getShipmentApi(): Api\Shop\ShipmentApiInterface;
    public function getPaymentMethodApi(): Api\Shop\PaymentMethodApiInterface;
    public function getProductImageApi(): Api\Shop\ProductImageApiInterface;
    public function getProductOptionValueApi(): Api\Shop\ProductOptionValueApiInterface;
    public function getProductOptionApi(): Api\Shop\ProductOptionApiInterface;
    public function getProductReviewApi(): Api\Shop\ProductReviewApiInterface;
    public function getProductTaxonApi(): Api\Shop\ProductTaxonApiInterface;
    public function getProductTranslationApi(): Api\Shop\ProductTranslationApiInterface;
    public function getProductVariantTranslationApi(): Api\Shop\ProductVariantTranslationApiInterface;
    public function getProductVariantApi(): Api\Shop\ProductVariantApiInterface;
    public function getProductApi(): Api\Shop\ProductApiInterface;
    public function getShippingMethodApi(): Api\Shop\ShippingMethodApiInterface;
    public function getShippingMethodTranslationApi(): Api\Shop\ShippingMethodTranslationApiInterface;
    public function getTaxonTranslationApi(): Api\Shop\TaxonTranslationApiInterface;
    public function getTaxonApi(): Api\Shop\TaxonApiInterface;
    public function getVerifyCustomerAccountApi(): Api\Shop\VerifyCustomerAccountApiInterface;
    public function getResetPasswordRequestApi(): Api\Shop\ResetPasswordRequestApiInterface;
}
