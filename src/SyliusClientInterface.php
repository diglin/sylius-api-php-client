<?php

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api\CartsApiInterface;
use Diglin\Sylius\ApiClient\Api\ChannelsApiInterface;
use Diglin\Sylius\ApiClient\Api\CountriesApiInterface;
use Diglin\Sylius\ApiClient\Api\CurrenciesApiInterface;
use Diglin\Sylius\ApiClient\Api\CustomersApiInterface;
use Diglin\Sylius\ApiClient\Api\ExchangeRatesApiInterface;
use Diglin\Sylius\ApiClient\Api\LocalesApiInterface;
use Diglin\Sylius\ApiClient\Api\OrdersApiInterface;
use Diglin\Sylius\ApiClient\Api\PaymentMethodsApiInterface;
use Diglin\Sylius\ApiClient\Api\PaymentsApiInterface;
use Diglin\Sylius\ApiClient\Api\ProductAssociationTypesApiInterface;
use Diglin\Sylius\ApiClient\Api\ProductAttributesApiInterface;
use Diglin\Sylius\ApiClient\Api\ProductOptionsApiInterface;
use Diglin\Sylius\ApiClient\Api\ProductReviewsApiInterface;
use Diglin\Sylius\ApiClient\Api\ProductsApiInterface;
use Diglin\Sylius\ApiClient\Api\ProductVariantsApiInterface;
use Diglin\Sylius\ApiClient\Api\PromotionCouponsApiInterface;
use Diglin\Sylius\ApiClient\Api\PromotionsApiInterface;
use Diglin\Sylius\ApiClient\Api\ShipmentsApiInterface;
use Diglin\Sylius\ApiClient\Api\ShippingCategoriesApi;
use Diglin\Sylius\ApiClient\Api\TaxCategoriesApiInterface;
use Diglin\Sylius\ApiClient\Api\TaxonsApiInterface;
use Diglin\Sylius\ApiClient\Api\TaxRatesApiInterface;
use Diglin\Sylius\ApiClient\Api\UsersApiInterface;
use Diglin\Sylius\ApiClient\Api\ZonesApiInterface;

interface SyliusClientInterface
{
    /**
     * Gets the authentication access token.
     */
    public function getToken(): ?string;

    /**
     * Gets the authentication refresh token.
     */
    public function getRefreshToken(): ?string;

    public function getChannelsApi(): ChannelsApiInterface;

    public function getShippingCategoriesApi(): ShippingCategoriesApi;

    public function getLocalesApi(): LocalesApiInterface;

    public function getCurrenciesApi(): CurrenciesApiInterface;

    public function getCountriesApi(): CountriesApiInterface;

    public function getExchangeRatesApi(): ExchangeRatesApiInterface;

    public function getPaymentMethodsApi(): PaymentMethodsApiInterface;

    public function getUsersApi(): UsersApiInterface;

    public function getCustomersApi(): CustomersApiInterface;

    public function getProductsApi(): ProductsApiInterface;

    public function getProductAttributesApi(): ProductAttributesApiInterface;

    public function getProductAssociationTypesApi(): ProductAssociationTypesApiInterface;

    public function getProductOptionsApi(): ProductOptionsApiInterface;

    public function getProductReviewsApi(): ProductReviewsApiInterface;

    public function getProductVariantsApi(): ProductVariantsApiInterface;

    public function getPromotionsApi(): PromotionsApiInterface;

    public function getPromotionCouponsApi(): PromotionCouponsApiInterface;

    public function getCartsApi(): CartsApiInterface;

    public function getOrdersApi(): OrdersApiInterface;

    public function getPaymentsApi(): PaymentsApiInterface;

    public function getShipmentsApi(): ShipmentsApiInterface;

    public function getTaxCategoriesApi(): TaxCategoriesApiInterface;

    public function getTaxRatesApi(): TaxRatesApiInterface;

    public function getTaxonsApi(): TaxonsApiInterface;

    public function getZonesApi(): ZonesApiInterface;
}
