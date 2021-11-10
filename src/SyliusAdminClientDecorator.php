<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;

class SyliusAdminClientDecorator implements SyliusAdminClientInterface
{
    /** @var list<Api\ApiAwareInterface> */
    private array $apiRegistry = [];

    public function __construct(
        private SyliusAdminClientInterface $decoratedClient
    ) {}

    public function __call($name, $arguments)
    {
        $property = lcfirst(substr($name, 3));
        if ('get' === substr($name, 0, 3) && isset($this->apiRegistry[$property])) {
            return $this->apiRegistry[$property];
        }

        return $this->decoratedClient->{$name}($arguments);
    }

    public function addApi(string $key, Api\ApiAwareInterface $api)
    {
        $this->apiRegistry[$key] = $api;
    }

    public function get(string $name): ?Api\ApiAwareInterface
    {
        return $this->apiRegistry[$name] ?? null;
    }

    public function getAddressApi(): Api\Admin\AddressApiInterface
    {
        return $this->decoratedClient->getAddressApi();
    }

    public function getAdjustmentApi(): Api\Admin\AdjustmentApiInterface
    {
        return $this->decoratedClient->getAdjustmentApi();
    }

    public function getAdministratorApi(): Api\Admin\AdministratorApiInterface
    {
        return $this->decoratedClient->getAdministratorApi();
    }

    public function getAvatarImageApi(): Api\Admin\AvatarImageApiInterface
    {
        return $this->decoratedClient->getAvatarImageApi();
    }

    public function getCatalogPromotionTranslationApi(): Api\Admin\CatalogPromotionTranslationApiInterface
    {
        return $this->decoratedClient->getCatalogPromotionTranslationApi();
    }

    public function getCatalogPromotionApi(): Api\Admin\CatalogPromotionApiInterface
    {
        return $this->decoratedClient->getCatalogPromotionApi();
    }

    public function getChannelApi(): Api\Admin\ChannelApiInterface
    {
        return $this->decoratedClient->getChannelApi();
    }

    public function getShopBillingDataApi(): Api\Admin\ShopBillingDataApiInterface
    {
        return $this->decoratedClient->getShopBillingDataApi();
    }

    public function getCountryApi(): Api\Admin\CountryApiInterface
    {
        return $this->decoratedClient->getCountryApi();
    }

    public function getProvinceApi(): Api\Admin\ProvinceApiInterface
    {
        return $this->decoratedClient->getProvinceApi();
    }

    public function getCurrencyApi(): Api\Admin\CurrencyApiInterface
    {
        return $this->decoratedClient->getCurrencyApi();
    }

    public function getCustomerGroupApi(): Api\Admin\CustomerGroupApiInterface
    {
        return $this->decoratedClient->getCustomerGroupApi();
    }

    public function getCustomerApi(): Api\Admin\CustomerApiInterface
    {
        return $this->decoratedClient->getCustomerApi();
    }

    public function getExchangeRateApi(): Api\Admin\ExchangeRateApiInterface
    {
        return $this->decoratedClient->getExchangeRateApi();
    }

    public function getLocaleApi(): Api\Admin\LocaleApiInterface
    {
        return $this->decoratedClient->getLocaleApi();
    }

    public function getOrderItemUnitApi(): Api\Admin\OrderItemUnitApiInterface
    {
        return $this->decoratedClient->getOrderItemUnitApi();
    }

    public function getOrderItemApi(): Api\Admin\OrderItemApiInterface
    {
        return $this->decoratedClient->getOrderItemApi();
    }

    public function getOrderApi(): Api\Admin\OrderApiInterface
    {
        return $this->decoratedClient->getOrderApi();
    }

    public function getPaymentApi(): Api\Admin\PaymentApiInterface
    {
        return $this->decoratedClient->getPaymentApi();
    }

    public function getShipmentApi(): Api\Admin\ShipmentApiInterface
    {
        return $this->decoratedClient->getShipmentApi();
    }

    public function getPaymentMethodApi(): Api\Admin\PaymentMethodApiInterface
    {
        return $this->decoratedClient->getPaymentMethodApi();
    }

    public function getProductAssociationTypeTranslationApi(): Api\Admin\ProductAssociationTypeTranslationApiInterface
    {
        return $this->decoratedClient->getProductAssociationTypeTranslationApi();
    }

    public function getProductAssociationTypeApi(): Api\Admin\ProductAssociationTypeApiInterface
    {
        return $this->decoratedClient->getProductAssociationTypeApi();
    }

    public function getProductImageApi(): Api\Admin\ProductImageApiInterface
    {
        return $this->decoratedClient->getProductImageApi();
    }

    public function getProductOptionTranslationApi(): Api\Admin\ProductOptionTranslationApiInterface
    {
        return $this->decoratedClient->getProductOptionTranslationApi();
    }

    public function getProductOptionValueApi(): Api\Admin\ProductOptionValueApiInterface
    {
        return $this->decoratedClient->getProductOptionValueApi();
    }

    public function getProductOptionApi(): Api\Admin\ProductOptionApiInterface
    {
        return $this->decoratedClient->getProductOptionApi();
    }

    public function getProductReviewApi(): Api\Admin\ProductReviewApiInterface
    {
        return $this->decoratedClient->getProductReviewApi();
    }

    public function getProductTaxonApi(): Api\Admin\ProductTaxonApiInterface
    {
        return $this->decoratedClient->getProductTaxonApi();
    }

    public function getProductTranslationApi(): Api\Admin\ProductTranslationApiInterface
    {
        return $this->decoratedClient->getProductTranslationApi();
    }

    public function getProductVariantTranslationApi(): Api\Admin\ProductVariantTranslationApiInterface
    {
        return $this->decoratedClient->getProductVariantTranslationApi();
    }

    public function getProductVariantApi(): Api\Admin\ProductVariantApiInterface
    {
        return $this->decoratedClient->getProductVariantApi();
    }

    public function getProductApi(): Api\Admin\ProductApiInterface
    {
        return $this->decoratedClient->getProductApi();
    }

    public function getPromotionApi(): Api\Admin\PromotionApiInterface
    {
        return $this->decoratedClient->getPromotionApi();
    }

    public function getShippingCategoryApi(): Api\Admin\ShippingCategoryApiInterface
    {
        return $this->decoratedClient->getShippingCategoryApi();
    }

    public function getShippingMethodTranslationApi(): Api\Admin\ShippingMethodTranslationApiInterface
    {
        return $this->decoratedClient->getShippingMethodTranslationApi();
    }

    public function getShippingMethodApi(): Api\Admin\ShippingMethodApiInterface
    {
        return $this->decoratedClient->getShippingMethodApi();
    }

    public function getTaxCategoryApi(): Api\Admin\TaxCategoryApiInterface
    {
        return $this->decoratedClient->getTaxCategoryApi();
    }

    public function getTaxonTranslationApi(): Api\Admin\TaxonTranslationApiInterface
    {
        return $this->decoratedClient->getTaxonTranslationApi();
    }

    public function getTaxonApi(): Api\Admin\TaxonApiInterface
    {
        return $this->decoratedClient->getTaxonApi();
    }

    public function getZoneMemberApi(): Api\Admin\ZoneMemberApiInterface
    {
        return $this->decoratedClient->getZoneMemberApi();
    }

    public function getZoneApi(): Api\Admin\ZoneApiInterface
    {
        return $this->decoratedClient->getZoneApi();
    }

    public function getVerifyCustomerAccountApi(): Api\Admin\VerifyCustomerAccountApiInterface
    {
        return $this->decoratedClient->getVerifyCustomerAccountApi();
    }

    public function getResetPasswordRequestApi(): Api\Admin\ResetPasswordRequestApiInterface
    {
        return $this->decoratedClient->getResetPasswordRequestApi();
    }
}
