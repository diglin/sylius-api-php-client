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
use Diglin\Sylius\ApiClient\Api\Legacy AS Api;

class SyliusLegacyClientDecorator implements SyliusLegacyClientInterface
{
    private SyliusLegacyClientInterface $decoratedClient;
    /** @var list<ApiAwareInterface> */
    private array $apiRegistry = [];

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

    public function getChannelsApi(): Api\ChannelsApiInterface
    {
        return $this->decoratedClient->getChannelsApi();
    }

    public function getShippingCategoriesApi(): Api\ShippingCategoriesApiInterface
    {
        return $this->decoratedClient->getShippingCategoriesApi();
    }

    public function getLocalesApi(): Api\LocalesApiInterface
    {
        return $this->decoratedClient->getLocalesApi();
    }

    public function getCurrenciesApi(): Api\CurrenciesApiInterface
    {
        return $this->decoratedClient->getCurrenciesApi();
    }

    public function getCountriesApi(): Api\CountriesApiInterface
    {
        return $this->decoratedClient->getCountriesApi();
    }

    public function getExchangeRatesApi(): Api\ExchangeRatesApiInterface
    {
        return $this->decoratedClient->getExchangeRatesApi();
    }

    public function getPaymentMethodsApi(): Api\PaymentMethodsApiInterface
    {
        return $this->decoratedClient->getPaymentMethodsApi();
    }

    public function getUsersApi(): Api\UsersApiInterface
    {
        return $this->decoratedClient->getUsersApi();
    }

    public function getCustomersApi(): Api\CustomersApiInterface
    {
        return $this->decoratedClient->getCustomersApi();
    }

    public function getProductsApi(): Api\ProductsApiInterface
    {
        return $this->decoratedClient->getProductsApi();
    }

    public function getProductAttributesApi(): Api\ProductAttributesApiInterface
    {
        return $this->decoratedClient->getProductAttributesApi();
    }

    public function getProductAssociationTypesApi(): Api\ProductAssociationTypesApiInterface
    {
        return $this->decoratedClient->getProductAssociationTypesApi();
    }

    public function getProductOptionsApi(): Api\ProductOptionsApiInterface
    {
        return $this->decoratedClient->getProductOptionsApi();
    }

    public function getProductReviewsApi(): Api\ProductReviewsApiInterface
    {
        return $this->decoratedClient->getProductReviewsApi();
    }

    public function getProductVariantsApi(): Api\ProductVariantsApiInterface
    {
        return $this->decoratedClient->getProductVariantsApi();
    }

    public function getPromotionsApi(): Api\PromotionsApiInterface
    {
        return $this->decoratedClient->getPromotionsApi();
    }

    public function getPromotionCouponsApi(): Api\PromotionCouponsApiInterface
    {
        return $this->decoratedClient->getPromotionCouponsApi();
    }

    public function getCartsApi(): Api\CartsApiInterface
    {
        return $this->decoratedClient->getCartsApi();
    }

    public function getOrdersApi(): Api\OrdersApiInterface
    {
        return $this->decoratedClient->getOrdersApi();
    }

    public function getPaymentsApi(): Api\PaymentsApiInterface
    {
        return $this->decoratedClient->getPaymentsApi();
    }

    public function getShipmentsApi(): Api\ShipmentsApiInterface
    {
        return $this->decoratedClient->getShipmentsApi();
    }

    public function getTaxCategoriesApi(): Api\TaxCategoriesApiInterface
    {
        return $this->decoratedClient->getTaxCategoriesApi();
    }

    public function getTaxRatesApi(): Api\TaxRatesApiInterface
    {
        return $this->decoratedClient->getTaxRatesApi();
    }

    public function getTaxonsApi(): Api\TaxonsApiInterface
    {
        return $this->decoratedClient->getTaxonsApi();
    }

    public function getZonesApi(): Api\ZonesApiInterface
    {
        return $this->decoratedClient->getZonesApi();
    }
}
