<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 *
 * @category    SyliusApiClient
 *
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api\Legacy as Api;
use Diglin\Sylius\ApiClient\Security\LegacyAuthentication;

class SyliusLegacyClient implements SyliusLegacyClientInterface
{
    public function __construct(
        private LegacyAuthentication $authentication,
        private Api\CartsApiInterface $cartsApi,
        private Api\ChannelsApiInterface $channelsApi,
        private Api\CountriesApiInterface $countriesApi,
        private Api\CurrenciesApiInterface $currenciesApi,
        private Api\CustomersApiInterface $customersApi,
        private Api\ExchangeRatesApiInterface $exchangeRatesApi,
        private Api\LocalesApiInterface $localesApi,
        private Api\OrdersApiInterface $ordersApi,
        private Api\PaymentMethodsApiInterface $paymentMethodsApi,
        private Api\PaymentsApiInterface $paymentsApi,
        private Api\ProductsApiInterface $productsApi,
        private Api\ProductAttributesApiInterface $productAttributesApi,
        private Api\ProductAssociationTypesApiInterface $productAssociationTypesApi,
        private Api\ProductOptionsApiInterface $productOptionsApi,
        private Api\ProductReviewsApiInterface $productReviewsApi,
        private Api\ProductVariantsApiInterface $productVariantsApi,
        private Api\PromotionsApiInterface $promotionsApi,
        private Api\PromotionCouponsApiInterface $promotionCouponsApi,
        private Api\ShipmentsApiInterface $shipmentsApi,
        private Api\ShippingCategoriesApiInterface $shippingCategoriesApi,
        private Api\TaxCategoriesApiInterface $taxCategoriesApi,
        private Api\TaxRatesApiInterface $taxRatesApi,
        private Api\TaxonsApiInterface $taxonsApi,
        private Api\UsersApiInterface $usersApi,
        private Api\ZonesApiInterface $zonesApi
    ) {}

    public function getZonesApi(): Api\ZonesApiInterface
    {
        return $this->zonesApi;
    }

    public function getTaxonsApi(): Api\TaxonsApiInterface
    {
        return $this->taxonsApi;
    }

    public function getTaxRatesApi(): Api\TaxRatesApiInterface
    {
        return $this->taxRatesApi;
    }

    public function getTaxCategoriesApi(): Api\TaxCategoriesApiInterface
    {
        return $this->taxCategoriesApi;
    }

    public function getPromotionCouponsApi(): Api\PromotionCouponsApiInterface
    {
        return $this->promotionCouponsApi;
    }

    public function getPromotionsApi(): Api\PromotionsApiInterface
    {
        return $this->promotionsApi;
    }

    public function getProductVariantsApi(): Api\ProductVariantsApiInterface
    {
        return $this->productVariantsApi;
    }

    public function getProductReviewsApi(): Api\ProductReviewsApiInterface
    {
        return $this->productReviewsApi;
    }

    public function getProductOptionsApi(): Api\ProductOptionsApiInterface
    {
        return $this->productOptionsApi;
    }

    public function getProductAssociationTypesApi(): Api\ProductAssociationTypesApiInterface
    {
        return $this->productAssociationTypesApi;
    }

    public function getProductAttributesApi(): Api\ProductAttributesApiInterface
    {
        return $this->productAttributesApi;
    }

    public function getShippingCategoriesApi(): Api\ShippingCategoriesApiInterface
    {
        return $this->shippingCategoriesApi;
    }

    public function getLocalesApi(): Api\LocalesApiInterface
    {
        return $this->localesApi;
    }

    public function getCurrenciesApi(): Api\CurrenciesApiInterface
    {
        return $this->currenciesApi;
    }

    public function getCountriesApi(): Api\CountriesApiInterface
    {
        return $this->countriesApi;
    }

    public function getExchangeRatesApi(): Api\ExchangeRatesApiInterface
    {
        return $this->exchangeRatesApi;
    }

    public function getPaymentMethodsApi(): Api\PaymentMethodsApiInterface
    {
        return $this->paymentMethodsApi;
    }

    public function getUsersApi(): Api\UsersApiInterface
    {
        return $this->usersApi;
    }

    public function getCustomersApi(): Api\CustomersApiInterface
    {
        return $this->customersApi;
    }

    public function getProductsApi(): Api\ProductsApiInterface
    {
        return $this->productsApi;
    }

    public function getCartsApi(): Api\CartsApiInterface
    {
        return $this->cartsApi;
    }

    public function getOrdersApi(): Api\OrdersApiInterface
    {
        return $this->ordersApi;
    }

    public function getPaymentsApi(): Api\PaymentsApiInterface
    {
        return $this->paymentsApi;
    }

    public function getShipmentsApi(): Api\ShipmentsApiInterface
    {
        return $this->shipmentsApi;
    }

    public function getChannelsApi(): Api\ChannelsApiInterface
    {
        return $this->channelsApi;
    }

    public function getToken(): ?string
    {
        return $this->authentication->getAccessToken();
    }

    public function getRefreshToken(): ?string
    {
        return $this->authentication->getRefreshToken();
    }
}
