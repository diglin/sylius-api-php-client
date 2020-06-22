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
use Diglin\Sylius\ApiClient\Security\Authentication;

class SyliusClient implements SyliusClientInterface
{
    /** @var Authentication */
    private $authentication;

    /** @var ChannelsApiInterface */
    private $channelsApi;
    /** @var UsersApiInterface */
    private $usersApi;
    /** @var CustomersApiInterface */
    private $customersApi;
    /** @var ProductsApiInterface */
    private $productsApi;
    /** @var CartsApiInterface */
    private $cartsApi;
    /** @var OrdersApiInterface */
    private $ordersApi;
    /** @var PaymentsApiInterface */
    private $paymentsApi;
    /** @var ShipmentsApiInterface */
    private $shipmentsApi;
    /** @var ShippingCategoriesApi */
    private $shippingCategoriesApi;
    /** @var LocalesApiInterface */
    private $localesApi;
    /** @var CurrenciesApiInterface */
    private $currenciesApi;
    /** @var CountriesApiInterface */
    private $countriesApi;
    /** @var ExchangeRatesApiInterface */
    private $exchangeRatesApi;
    /** @var PaymentMethodsApiInterface */
    private $paymentMethodsApi;
    /** @var ProductAttributesApiInterface */
    private $productAttributesApi;
    /** @var ProductAssociationTypesApiInterface */
    private $productAssociationTypesApi;
    /** @var ProductOptionsApiInterface */
    private $productOptionsApi;
    /** @var ProductReviewsApiInterface */
    private $productReviewsApi;
    /** @var ProductVariantsApiInterface */
    private $productVariantsApi;
    /** @var PromotionsApiInterface */
    private $promotionsApi;
    /** @var PromotionCouponsApiInterface */
    private $promotionCouponsApi;
    /** @var TaxCategoriesApiInterface */
    private $taxCategoriesApi;
    /** @var TaxRatesApiInterface */
    private $taxRatesApi;
    /** @var TaxonsApiInterface */
    private $taxonsApi;
    /** @var ZonesApiInterface */
    private $zonesApi;

    public function __construct(
        Authentication $authentication,
        CartsApiInterface $cartsApi,
        ChannelsApiInterface $channelsApi,
        CountriesApiInterface $countriesApi,
        CurrenciesApiInterface $currenciesApi,
        CustomersApiInterface $customersApi,
        ExchangeRatesApiInterface $exchangeRatesApi,
        LocalesApiInterface $localesApi,
        OrdersApiInterface $ordersApi,
        PaymentMethodsApiInterface $paymentMethodApi,
        PaymentsApiInterface $paymentsApi,
        ProductsApiInterface $productsApi,
        ProductAttributesApiInterface $productAttributesApi,
        ProductAssociationTypesApiInterface $productAssociationTypesApi,
        ProductOptionsApiInterface $productOptionsApi,
        ProductReviewsApiInterface $productReviewsApi,
        ProductVariantsApiInterface $productVariantsApi,
        PromotionsApiInterface $promotionsApi,
        PromotionCouponsApiInterface $promotionCouponsApi,
        ShipmentsApiInterface $shipmentsApi,
        ShippingCategoriesApi $shippingCategoriesApi,
        TaxCategoriesApiInterface $taxCategoriesApi,
        TaxRatesApiInterface $taxRatesApi,
        TaxonsApiInterface $taxonsApi,
        UsersApiInterface $usersApi,
        ZonesApiInterface $zonesApi
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

    public function getZonesApi(): ZonesApiInterface
    {
        return $this->zonesApi;
    }

    public function getTaxonsApi(): TaxonsApiInterface
    {
        return $this->taxonsApi;
    }

    public function getTaxRatesApi(): TaxRatesApiInterface
    {
        return $this->taxRatesApi;
    }

    public function getTaxCategoriesApi(): TaxCategoriesApiInterface
    {
        return $this->taxCategoriesApi;
    }

    public function getPromotionCouponsApi(): PromotionCouponsApiInterface
    {
        return $this->promotionCouponsApi;
    }

    public function getPromotionsApi(): PromotionsApiInterface
    {
        return $this->promotionsApi;
    }

    public function getProductVariantsApi(): ProductVariantsApiInterface
    {
        return $this->productVariantsApi;
    }

    public function getProductReviewsApi(): ProductReviewsApiInterface
    {
        return $this->productReviewsApi;
    }

    public function getProductOptionsApi(): ProductOptionsApiInterface
    {
        return $this->productOptionsApi;
    }

    public function getProductAssociationTypesApi(): ProductAssociationTypesApiInterface
    {
        return $this->productAssociationTypesApi;
    }

    public function getProductAttributesApi(): ProductAttributesApiInterface
    {
        return $this->productAttributesApi;
    }

    public function getShippingCategoriesApi(): ShippingCategoriesApi
    {
        return $this->shippingCategoriesApi;
    }

    public function getLocalesApi(): LocalesApiInterface
    {
        return $this->localesApi;
    }

    public function getCurrenciesApi(): CurrenciesApiInterface
    {
        return $this->currenciesApi;
    }

    public function getCountriesApi(): CountriesApiInterface
    {
        return $this->countriesApi;
    }

    public function getExchangeRatesApi(): ExchangeRatesApiInterface
    {
        return $this->exchangeRatesApi;
    }

    public function getPaymentMethodsApi(): PaymentMethodsApiInterface
    {
        return $this->paymentMethodsApi;
    }

    public function getUsersApi(): UsersApiInterface
    {
        return $this->usersApi;
    }

    public function getCustomersApi(): CustomersApiInterface
    {
        return $this->customersApi;
    }

    public function getProductsApi(): ProductsApiInterface
    {
        return $this->productsApi;
    }

    public function getCartsApi(): CartsApiInterface
    {
        return $this->cartsApi;
    }

    public function getOrdersApi(): OrdersApiInterface
    {
        return $this->ordersApi;
    }

    public function getPaymentsApi(): PaymentsApiInterface
    {
        return $this->paymentsApi;
    }

    public function getShipmentsApi(): ShipmentsApiInterface
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

    public function getChannelsApi(): ChannelsApiInterface
    {
        return $this->channelsApi;
    }
}
