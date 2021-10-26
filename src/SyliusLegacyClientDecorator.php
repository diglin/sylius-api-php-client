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

use Diglin\Sylius\ApiClient\Api\ApiAwareInterface;
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

class SyliusLegacyClientDecorator implements SyliusLegacyClientInterface
{
    /** @var SyliusLegacyClientInterface */
    protected $decoratedClient;

    /** @var ApiAwareInterface[] */
    protected $apiRegistry = [];

    public function __construct(
        SyliusLegacyClientInterface $decoratedClient
    ) {
        $this->decoratedClient = $decoratedClient;
    }

    public function __call($name, $arguments)
    {
        $property = lcfirst(substr($name, 3));
        if ('get' === substr($name, 0, 3) && isset($this->apiRegistry[$property])) {
            return $this->apiRegistry[$property];
        }

        return $this->decoratedClient->{$name}($arguments);
    }

    public function addApi(string $key, ApiAwareInterface $api)
    {
        $this->apiRegistry[$key] = $api;
    }

    public function get(string $name): ?ApiAwareInterface
    {
        return $this->apiRegistry[$name] ?? null;
    }

    public function getToken(): ?string
    {
        return $this->decoratedClient->getToken();
    }

    public function getRefreshToken(): ?string
    {
        return $this->decoratedClient->getRefreshToken();
    }

    public function getChannelsApi(): ChannelsApiInterface
    {
        return $this->decoratedClient->getChannelsApi();
    }

    public function getShippingCategoriesApi(): ShippingCategoriesApi
    {
        return $this->decoratedClient->getShippingCategoriesApi();
    }

    public function getLocalesApi(): LocalesApiInterface
    {
        return $this->decoratedClient->getLocalesApi();
    }

    public function getCurrenciesApi(): CurrenciesApiInterface
    {
        return $this->decoratedClient->getCurrenciesApi();
    }

    public function getCountriesApi(): CountriesApiInterface
    {
        return $this->decoratedClient->getCountriesApi();
    }

    public function getExchangeRatesApi(): ExchangeRatesApiInterface
    {
        return $this->decoratedClient->getExchangeRatesApi();
    }

    public function getPaymentMethodsApi(): PaymentMethodsApiInterface
    {
        return $this->decoratedClient->getPaymentMethodsApi();
    }

    public function getUsersApi(): UsersApiInterface
    {
        return $this->decoratedClient->getUsersApi();
    }

    public function getCustomersApi(): CustomersApiInterface
    {
        return $this->decoratedClient->getCustomersApi();
    }

    public function getProductsApi(): ProductsApiInterface
    {
        return $this->decoratedClient->getProductsApi();
    }

    public function getProductAttributesApi(): ProductAttributesApiInterface
    {
        return $this->decoratedClient->getProductAttributesApi();
    }

    public function getProductAssociationTypesApi(): ProductAssociationTypesApiInterface
    {
        return $this->decoratedClient->getProductAssociationTypesApi();
    }

    public function getProductOptionsApi(): ProductOptionsApiInterface
    {
        return $this->decoratedClient->getProductOptionsApi();
    }

    public function getProductReviewsApi(): ProductReviewsApiInterface
    {
        return $this->decoratedClient->getProductReviewsApi();
    }

    public function getProductVariantsApi(): ProductVariantsApiInterface
    {
        return $this->decoratedClient->getProductVariantsApi();
    }

    public function getPromotionsApi(): PromotionsApiInterface
    {
        return $this->decoratedClient->getPromotionsApi();
    }

    public function getPromotionCouponsApi(): PromotionCouponsApiInterface
    {
        return $this->decoratedClient->getPromotionCouponsApi();
    }

    public function getCartsApi(): CartsApiInterface
    {
        return $this->decoratedClient->getCartsApi();
    }

    public function getOrdersApi(): OrdersApiInterface
    {
        return $this->decoratedClient->getOrdersApi();
    }

    public function getPaymentsApi(): PaymentsApiInterface
    {
        return $this->decoratedClient->getPaymentsApi();
    }

    public function getShipmentsApi(): ShipmentsApiInterface
    {
        return $this->decoratedClient->getShipmentsApi();
    }

    public function getTaxCategoriesApi(): TaxCategoriesApiInterface
    {
        return $this->decoratedClient->getTaxCategoriesApi();
    }

    public function getTaxRatesApi(): TaxRatesApiInterface
    {
        return $this->decoratedClient->getTaxRatesApi();
    }

    public function getTaxonsApi(): TaxonsApiInterface
    {
        return $this->decoratedClient->getTaxonsApi();
    }

    public function getZonesApi(): ZonesApiInterface
    {
        return $this->decoratedClient->getZonesApi();
    }
}
