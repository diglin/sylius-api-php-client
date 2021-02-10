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

use Diglin\Sylius\ApiClient\Api;
use Diglin\Sylius\ApiClient\Security\Authentication;

class SyliusClient implements SyliusClientInterface
{
    /** @var Authentication */
    private $authentication;

    /** @var Api\ChannelsApiInterface */
    private $channelsApi;
    /** @var Api\UsersApiInterface */
    private $usersApi;
    /** @var Api\CustomersApiInterface */
    private $customersApi;
    /** @var Api\ProductsApiInterface */
    private $productsApi;
    /** @var Api\CartsApiInterface */
    private $cartsApi;
    /** @var Api\OrdersApiInterface */
    private $ordersApi;
    /** @var Api\PaymentsApiInterface */
    private $paymentsApi;
    /** @var Api\ShipmentsApiInterface */
    private $shipmentsApi;
    /** @var Api\ShippingCategoriesApiInterface */
    private $shippingCategoriesApi;
    /** @var Api\LocalesApiInterface */
    private $localesApi;
    /** @var Api\CurrenciesApiInterface */
    private $currenciesApi;
    /** @var Api\CountriesApiInterface */
    private $countriesApi;
    /** @var Api\ExchangeRatesApiInterface */
    private $exchangeRatesApi;
    /** @var Api\PaymentMethodsApiInterface */
    private $paymentMethodsApi;
    /** @var Api\ProductAttributesApiInterface */
    private $productAttributesApi;
    /** @var Api\ProductAssociationTypesApiInterface */
    private $productAssociationTypesApi;
    /** @var Api\ProductOptionsApiInterface */
    private $productOptionsApi;
    /** @var Api\ProductReviewsApiInterface */
    private $productReviewsApi;
    /** @var Api\ProductVariantsApiInterface */
    private $productVariantsApi;
    /** @var Api\PromotionsApiInterface */
    private $promotionsApi;
    /** @var Api\PromotionCouponsApiInterface */
    private $promotionCouponsApi;
    /** @var Api\TaxCategoriesApiInterface */
    private $taxCategoriesApi;
    /** @var Api\TaxRatesApiInterface */
    private $taxRatesApi;
    /** @var Api\TaxonsApiInterface */
    private $taxonsApi;
    /** @var Api\ZonesApiInterface */
    private $zonesApi;

    public function __construct(
        Authentication $authentication,
        Api\CartsApiInterface $cartsApi,
        Api\ChannelsApiInterface $channelsApi,
        Api\CountriesApiInterface $countriesApi,
        Api\CurrenciesApiInterface $currenciesApi,
        Api\CustomersApiInterface $customersApi,
        Api\ExchangeRatesApiInterface $exchangeRatesApi,
        Api\LocalesApiInterface $localesApi,
        Api\OrdersApiInterface $ordersApi,
        Api\PaymentMethodsApiInterface $paymentMethodApi,
        Api\PaymentsApiInterface $paymentsApi,
        Api\ProductsApiInterface $productsApi,
        Api\ProductAttributesApiInterface $productAttributesApi,
        Api\ProductAssociationTypesApiInterface $productAssociationTypesApi,
        Api\ProductOptionsApiInterface $productOptionsApi,
        Api\ProductReviewsApiInterface $productReviewsApi,
        Api\ProductVariantsApiInterface $productVariantsApi,
        Api\PromotionsApiInterface $promotionsApi,
        Api\PromotionCouponsApiInterface $promotionCouponsApi,
        Api\ShipmentsApiInterface $shipmentsApi,
        Api\ShippingCategoriesApiInterface $shippingCategoriesApi,
        Api\TaxCategoriesApiInterface $taxCategoriesApi,
        Api\TaxRatesApiInterface $taxRatesApi,
        Api\TaxonsApiInterface $taxonsApi,
        Api\UsersApiInterface $usersApi,
        Api\ZonesApiInterface $zonesApi
    ) {
        $this->authentication = $authentication;
        $this->channelsApi = $channelsApi;
        $this->usersApi = $usersApi;
        $this->customersApi = $customersApi;
        $this->productsApi = $productsApi;
        $this->cartsApi = $cartsApi;
        $this->ordersApi = $ordersApi;
        $this->paymentsApi = $paymentsApi;
        $this->shipmentsApi = $shipmentsApi;
        $this->shippingCategoriesApi = $shippingCategoriesApi;
        $this->localesApi = $localesApi;
        $this->currenciesApi = $currenciesApi;
        $this->countriesApi = $countriesApi;
        $this->exchangeRatesApi = $exchangeRatesApi;
        $this->paymentMethodsApi = $paymentMethodApi;
        $this->productAttributesApi = $productAttributesApi;
        $this->productAssociationTypesApi = $productAssociationTypesApi;
        $this->productOptionsApi = $productOptionsApi;
        $this->productReviewsApi = $productReviewsApi;
        $this->productVariantsApi = $productVariantsApi;
        $this->promotionsApi = $promotionsApi;
        $this->promotionCouponsApi = $promotionCouponsApi;
        $this->taxCategoriesApi = $taxCategoriesApi;
        $this->taxRatesApi = $taxRatesApi;
        $this->taxonsApi = $taxonsApi;
        $this->zonesApi = $zonesApi;
    }

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

    public function getShippingCategoriesApi(): Api\ShippingCategoriesApi
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

    public function getToken(): ?string
    {
        return $this->authentication->getAccessToken();
    }

    public function getRefreshToken(): ?string
    {
        return $this->authentication->getRefreshToken();
    }

    public function getChannelsApi(): Api\ChannelsApiInterface
    {
        return $this->channelsApi;
    }
}
