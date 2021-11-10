<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;
use Diglin\Sylius\ApiClient\Security\Authentication;

class SyliusAdminClient implements SyliusAdminClientInterface
{
    public function __construct(
        private Authentication $authentication,
        private Api\Admin\AddressApiInterface $addressApi,
        private Api\Admin\AdjustmentApiInterface $adjustmentApi,
        private Api\Admin\AdministratorApiInterface $administratorApi,
        private Api\Admin\AvatarImageApiInterface $avatarImageApi,
        private Api\Admin\CatalogPromotionTranslationApiInterface $catalogPromotionTranslationApi,
        private Api\Admin\CatalogPromotionApiInterface $catalogPromotionApi,
        private Api\Admin\ChannelApiInterface $channelApi,
        private Api\Admin\ShopBillingDataApiInterface $shopBillingDataApi,
        private Api\Admin\CountryApiInterface $countryApi,
        private Api\Admin\ProvinceApiInterface $provinceApi,
        private Api\Admin\CurrencyApiInterface $currencyApi,
        private Api\Admin\CustomerGroupApiInterface $customerGroupApi,
        private Api\Admin\CustomerApiInterface $customerApi,
        private Api\Admin\ExchangeRateApiInterface $exchangeRateApi,
        private Api\Admin\LocaleApiInterface $localeApi,
        private Api\Admin\OrderItemUnitApiInterface $orderItemUnitApi,
        private Api\Admin\OrderItemApiInterface $orderItemApi,
        private Api\Admin\OrderApiInterface $orderApi,
        private Api\Admin\PaymentApiInterface $paymentApi,
        private Api\Admin\ShipmentApiInterface $shipmentApi,
        private Api\Admin\PaymentMethodApiInterface $paymentMethodApi,
        private Api\Admin\ProductAssociationTypeTranslationApiInterface $productAssociationTypeTranslationApi,
        private Api\Admin\ProductAssociationTypeApiInterface $productAssociationTypeApi,
        private Api\Admin\ProductImageApiInterface $productImageApi,
        private Api\Admin\ProductOptionTranslationApiInterface $productOptionTranslationApi,
        private Api\Admin\ProductOptionValueApiInterface $productOptionValueApi,
        private Api\Admin\ProductOptionApiInterface $productOptionApi,
        private Api\Admin\ProductReviewApiInterface $productReviewApi,
        private Api\Admin\ProductTaxonApiInterface $productTaxonApi,
        private Api\Admin\ProductTranslationApiInterface $productTranslationApi,
        private Api\Admin\ProductVariantTranslationApiInterface $productVariantTranslationApi,
        private Api\Admin\ProductVariantApiInterface $productVariantApi,
        private Api\Admin\ProductApiInterface $productApi,
        private Api\Admin\PromotionApiInterface $promotionApi,
        private Api\Admin\ShippingCategoryApiInterface $shippingCategoryApi,
        private Api\Admin\ShippingMethodTranslationApiInterface $shippingMethodTranslationApi,
        private Api\Admin\ShippingMethodApiInterface $shippingMethodApi,
        private Api\Admin\TaxCategoryApiInterface $taxCategoryApi,
        private Api\Admin\TaxonTranslationApiInterface $taxonTranslationApi,
        private Api\Admin\TaxonApiInterface $taxonApi,
        private Api\Admin\ZoneMemberApiInterface $zoneMemberApi,
        private Api\Admin\ZoneApiInterface $zoneApi,
        private Api\Admin\VerifyCustomerAccountApiInterface $verifyCustomerAccountApi,
        private Api\Admin\ResetPasswordRequestApiInterface $resetPasswordRequestApi,
    ) {}

    public function getAddressApi(): Api\Admin\AddressApiInterface
    {
        return $this->addressApi;
    }

    public function getAdjustmentApi(): Api\Admin\AdjustmentApiInterface
    {
        return $this->adjustmentApi;
    }

    public function getAdministratorApi(): Api\Admin\AdministratorApiInterface
    {
        return $this->administratorApi;
    }

    public function getAvatarImageApi(): Api\Admin\AvatarImageApiInterface
    {
        return $this->avatarImageApi;
    }

    public function getCatalogPromotionTranslationApi(): Api\Admin\CatalogPromotionTranslationApiInterface
    {
        return $this->catalogPromotionTranslationApi;
    }

    public function getCatalogPromotionApi(): Api\Admin\CatalogPromotionApiInterface
    {
        return $this->catalogPromotionApi;
    }

    public function getChannelApi(): Api\Admin\ChannelApiInterface
    {
        return $this->channelApi;
    }

    public function getShopBillingDataApi(): Api\Admin\ShopBillingDataApiInterface
    {
        return $this->shopBillingDataApi;
    }

    public function getCountryApi(): Api\Admin\CountryApiInterface
    {
        return $this->countryApi;
    }

    public function getProvinceApi(): Api\Admin\ProvinceApiInterface
    {
        return $this->provinceApi;
    }

    public function getCurrencyApi(): Api\Admin\CurrencyApiInterface
    {
        return $this->currencyApi;
    }

    public function getCustomerGroupApi(): Api\Admin\CustomerGroupApiInterface
    {
        return $this->customerGroupApi;
    }

    public function getCustomerApi(): Api\Admin\CustomerApiInterface
    {
        return $this->customerApi;
    }

    public function getExchangeRateApi(): Api\Admin\ExchangeRateApiInterface
    {
        return $this->exchangeRateApi;
    }

    public function getLocaleApi(): Api\Admin\LocaleApiInterface
    {
        return $this->localeApi;
    }

    public function getOrderItemUnitApi(): Api\Admin\OrderItemUnitApiInterface
    {
        return $this->orderItemUnitApi;
    }

    public function getOrderItemApi(): Api\Admin\OrderItemApiInterface
    {
        return $this->orderItemApi;
    }

    public function getOrderApi(): Api\Admin\OrderApiInterface
    {
        return $this->orderApi;
    }

    public function getPaymentApi(): Api\Admin\PaymentApiInterface
    {
        return $this->paymentApi;
    }

    public function getShipmentApi(): Api\Admin\ShipmentApiInterface
    {
        return $this->shipmentApi;
    }

    public function getPaymentMethodApi(): Api\Admin\PaymentMethodApiInterface
    {
        return $this->paymentMethodApi;
    }

    public function getProductAssociationTypeTranslationApi(): Api\Admin\ProductAssociationTypeTranslationApiInterface
    {
        return $this->productAssociationTypeTranslationApi;
    }

    public function getProductAssociationTypeApi(): Api\Admin\ProductAssociationTypeApiInterface
    {
        return $this->productAssociationTypeApi;
    }

    public function getProductImageApi(): Api\Admin\ProductImageApiInterface
    {
        return $this->productImageApi;
    }

    public function getProductOptionTranslationApi(): Api\Admin\ProductOptionTranslationApiInterface
    {
        return $this->productOptionTranslationApi;
    }

    public function getProductOptionValueApi(): Api\Admin\ProductOptionValueApiInterface
    {
        return $this->productOptionValueApi;
    }

    public function getProductOptionApi(): Api\Admin\ProductOptionApiInterface
    {
        return $this->productOptionApi;
    }

    public function getProductReviewApi(): Api\Admin\ProductReviewApiInterface
    {
        return $this->productReviewApi;
    }

    public function getProductTaxonApi(): Api\Admin\ProductTaxonApiInterface
    {
        return $this->productTaxonApi;
    }

    public function getProductTranslationApi(): Api\Admin\ProductTranslationApiInterface
    {
        return $this->productTranslationApi;
    }

    public function getProductVariantTranslationApi(): Api\Admin\ProductVariantTranslationApiInterface
    {
        return $this->productVariantTranslationApi;
    }

    public function getProductVariantApi(): Api\Admin\ProductVariantApiInterface
    {
        return $this->productVariantApi;
    }

    public function getProductApi(): Api\Admin\ProductApiInterface
    {
        return $this->productApi;
    }

    public function getPromotionApi(): Api\Admin\PromotionApiInterface
    {
        return $this->promotionApi;
    }

    public function getShippingCategoryApi(): Api\Admin\ShippingCategoryApiInterface
    {
        return $this->shippingCategoryApi;
    }

    public function getShippingMethodTranslationApi(): Api\Admin\ShippingMethodTranslationApiInterface
    {
        return $this->shippingMethodTranslationApi;
    }

    public function getShippingMethodApi(): Api\Admin\ShippingMethodApiInterface
    {
        return $this->shippingMethodApi;
    }

    public function getTaxCategoryApi(): Api\Admin\TaxCategoryApiInterface
    {
        return $this->taxCategoryApi;
    }

    public function getTaxonTranslationApi(): Api\Admin\TaxonTranslationApiInterface
    {
        return $this->taxonTranslationApi;
    }

    public function getTaxonApi(): Api\Admin\TaxonApiInterface
    {
        return $this->taxonApi;
    }

    public function getZoneMemberApi(): Api\Admin\ZoneMemberApiInterface
    {
        return $this->zoneMemberApi;
    }

    public function getZoneApi(): Api\Admin\ZoneApiInterface
    {
        return $this->zoneApi;
    }

    public function getVerifyCustomerAccountApi(): Api\Admin\VerifyCustomerAccountApiInterface
    {
        return $this->verifyCustomerAccountApi;
    }

    public function getResetPasswordRequestApi(): Api\Admin\ResetPasswordRequestApiInterface
    {
        return $this->resetPasswordRequestApi;
    }
}
