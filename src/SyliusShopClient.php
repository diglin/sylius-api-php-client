<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;
use Diglin\Sylius\ApiClient\Security\Authentication;

class SyliusShopClient implements SyliusShopClientInterface
{
    public function __construct(
        private Authentication $authentication,
        private Api\Shop\AddressApiInterface $addressApi,
        private Api\Shop\AdjustmentApiInterface $adjustmentApi,
        private Api\Shop\CatalogPromotionApiInterface $catalogPromotionApi,
        private Api\Shop\ChannelApiInterface $channelApi,
        private Api\Shop\CountryApiInterface $countryApi,
        private Api\Shop\CurrencyApiInterface $currencyApi,
        private Api\Shop\CustomerApiInterface $customerApi,
        private Api\Shop\LocaleApiInterface $localeApi,
        private Api\Shop\OrderItemUnitApiInterface $orderItemUnitApi,
        private Api\Shop\OrderItemApiInterface $orderItemApi,
        private Api\Shop\OrderApiInterface $orderApi,
        private Api\Shop\PaymentApiInterface $paymentApi,
        private Api\Shop\ShipmentApiInterface $shipmentApi,
        private Api\Shop\PaymentMethodApiInterface $paymentMethodApi,
        private Api\Shop\ProductImageApiInterface $productImageApi,
        private Api\Shop\ProductOptionValueApiInterface $productOptionValueApi,
        private Api\Shop\ProductOptionApiInterface $productOptionApi,
        private Api\Shop\ProductReviewApiInterface $productReviewApi,
        private Api\Shop\ProductTaxonApiInterface $productTaxonApi,
        private Api\Shop\ProductTranslationApiInterface $productTranslationApi,
        private Api\Shop\ProductVariantTranslationApiInterface $productVariantTranslationApi,
        private Api\Shop\ProductVariantApiInterface $productVariantApi,
        private Api\Shop\ProductApiInterface $productApi,
        private Api\Shop\ShippingMethodApiInterface $shippingMethodApi,
        private Api\Shop\TaxonTranslationApiInterface $taxonTranslationApi,
        private Api\Shop\TaxonApiInterface $taxonApi,
        private Api\Shop\VerifyCustomerAccountApiInterface $verifyCustomerAccountApi,
        private Api\Shop\ResetPasswordRequestApiInterface $resetPasswordRequestApi,
    ) {}

    public function getAddressApi(): Api\Shop\AddressApiInterface
    {
        return $this->addressApi;
    }

    public function getAdjustmentApi(): Api\Shop\AdjustmentApiInterface
    {
        return $this->adjustmentApi;
    }

    public function getCatalogPromotionApi(): Api\Shop\CatalogPromotionApiInterface
    {
        return $this->catalogPromotionApi;
    }

    public function getChannelApi(): Api\Shop\ChannelApiInterface
    {
        return $this->channelApi;
    }

    public function getCountryApi(): Api\Shop\CountryApiInterface
    {
        return $this->countryApi;
    }

    public function getCurrencyApi(): Api\Shop\CurrencyApiInterface
    {
        return $this->currencyApi;
    }

    public function getCustomerApi(): Api\Shop\CustomerApiInterface
    {
        return $this->customerApi;
    }

    public function getLocaleApi(): Api\Shop\LocaleApiInterface
    {
        return $this->localeApi;
    }

    public function getOrderItemUnitApi(): Api\Shop\OrderItemUnitApiInterface
    {
        return $this->orderItemUnitApi;
    }

    public function getOrderItemApi(): Api\Shop\OrderItemApiInterface
    {
        return $this->orderItemApi;
    }

    public function getOrderApi(): Api\Shop\OrderApiInterface
    {
        return $this->orderApi;
    }

    public function getPaymentApi(): Api\Shop\PaymentApiInterface
    {
        return $this->paymentApi;
    }

    public function getShipmentApi(): Api\Shop\ShipmentApiInterface
    {
        return $this->shipmentApi;
    }

    public function getPaymentMethodApi(): Api\Shop\PaymentMethodApiInterface
    {
        return $this->paymentMethodApi;
    }

    public function getProductImageApi(): Api\Shop\ProductImageApiInterface
    {
        return $this->productImageApi;
    }

    public function getProductOptionValueApi(): Api\Shop\ProductOptionValueApiInterface
    {
        return $this->productOptionValueApi;
    }

    public function getProductOptionApi(): Api\Shop\ProductOptionApiInterface
    {
        return $this->productOptionApi;
    }

    public function getProductReviewApi(): Api\Shop\ProductReviewApiInterface
    {
        return $this->productReviewApi;
    }

    public function getProductTaxonApi(): Api\Shop\ProductTaxonApiInterface
    {
        return $this->productTaxonApi;
    }

    public function getProductTranslationApi(): Api\Shop\ProductTranslationApiInterface
    {
        return $this->productTranslationApi;
    }

    public function getProductVariantTranslationApi(): Api\Shop\ProductVariantTranslationApiInterface
    {
        return $this->productVariantTranslationApi;
    }

    public function getProductVariantApi(): Api\Shop\ProductVariantApiInterface
    {
        return $this->productVariantApi;
    }

    public function getProductApi(): Api\Shop\ProductApiInterface
    {
        return $this->productApi;
    }

    public function getShippingMethodApi(): Api\Shop\ShippingMethodApiInterface
    {
        return $this->shippingMethodApi;
    }

    public function getTaxonTranslationApi(): Api\Shop\TaxonTranslationApiInterface
    {
        return $this->taxonTranslationApi;
    }

    public function getTaxonApi(): Api\Shop\TaxonApiInterface
    {
        return $this->taxonApi;
    }

    public function getVerifyCustomerAccountApi(): Api\Shop\VerifyCustomerAccountApiInterface
    {
        return $this->verifyCustomerAccountApi;
    }

    public function getResetPasswordRequestApi(): Api\Shop\ResetPasswordRequestApiInterface
    {
        return $this->resetPasswordRequestApi;
    }
}
