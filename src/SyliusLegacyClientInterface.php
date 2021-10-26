<?php

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api\Legacy as Api;

interface SyliusLegacyClientInterface
{
    /**
     * Gets the authentication access token.
     */
    public function getToken(): ?string;

    /**
     * Gets the authentication refresh token.
     */
    public function getRefreshToken(): ?string;

    public function getChannelsApi(): Api\ChannelsApiInterface;

    public function getShippingCategoriesApi(): Api\ShippingCategoriesApiInterface;

    public function getLocalesApi(): Api\LocalesApiInterface;

    public function getCurrenciesApi(): Api\CurrenciesApiInterface;

    public function getCountriesApi(): Api\CountriesApiInterface;

    public function getExchangeRatesApi(): Api\ExchangeRatesApiInterface;

    public function getPaymentMethodsApi(): Api\PaymentMethodsApiInterface;

    public function getUsersApi(): Api\UsersApiInterface;

    public function getCustomersApi(): Api\CustomersApiInterface;

    public function getProductsApi(): Api\ProductsApiInterface;

    public function getProductAttributesApi(): Api\ProductAttributesApiInterface;

    public function getProductAssociationTypesApi(): Api\ProductAssociationTypesApiInterface;

    public function getProductOptionsApi(): Api\ProductOptionsApiInterface;

    public function getProductReviewsApi(): Api\ProductReviewsApiInterface;

    public function getProductVariantsApi(): Api\ProductVariantsApiInterface;

    public function getPromotionsApi(): Api\PromotionsApiInterface;

    public function getPromotionCouponsApi(): Api\PromotionCouponsApiInterface;

    public function getCartsApi(): Api\CartsApiInterface;

    public function getOrdersApi(): Api\OrdersApiInterface;

    public function getPaymentsApi(): Api\PaymentsApiInterface;

    public function getShipmentsApi(): Api\ShipmentsApiInterface;

    public function getTaxCategoriesApi(): Api\TaxCategoriesApiInterface;

    public function getTaxRatesApi(): Api\TaxRatesApiInterface;

    public function getTaxonsApi(): Api\TaxonsApiInterface;

    public function getZonesApi(): Api\ZonesApiInterface;
}
