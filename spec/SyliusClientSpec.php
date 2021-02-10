<?php

namespace spec\Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;
use Diglin\Sylius\ApiClient\Security\Authentication;
use Diglin\Sylius\ApiClient\SyliusClient;
use Diglin\Sylius\ApiClient\SyliusClientInterface;
use PhpSpec\ObjectBehavior;

class SyliusClientSpec extends ObjectBehavior
{
    public function let(
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
        $this->beConstructedWith(
            $authentication,
            $cartsApi,
            $channelsApi,
            $countriesApi,
            $currenciesApi,
            $customersApi,
            $exchangeRatesApi,
            $localesApi,
            $ordersApi,
            $paymentMethodApi,
            $paymentsApi,
            $productsApi,
            $productAttributesApi,
            $productAssociationTypesApi,
            $productOptionsApi,
            $productReviewsApi,
            $productVariantsApi,
            $promotionsApi,
            $promotionCouponsApi,
            $shipmentsApi,
            $shippingCategoriesApi,
            $taxCategoriesApi,
            $taxRatesApi,
            $taxonsApi,
            $usersApi,
            $zonesApi
        );
    }

    public function it_is_initializable()
    {
        $this->shouldImplement(SyliusClientInterface::class);
        $this->shouldHaveType(SyliusClient::class);
    }

    public function it_gets_access_token($authentication)
    {
        $authentication->getAccessToken()->willReturn('foo');

        $this->getToken()->shouldReturn('foo');
    }

    public function it_gets_refresh_token($authentication)
    {
        $authentication->getRefreshToken()->willReturn('bar');

        $this->getRefreshToken()->shouldReturn('bar');
    }

    public function it_gets_cart_api()
    {
        $this->getCartsApi()->shouldReturnAnInstanceOf(Api\CartsApiInterface::class);
    }

    public function it_gets_channel_api()
    {
        $this->getChannelsApi()->shouldReturnAnInstanceOf(Api\ChannelsApiInterface::class);
    }

    public function it_gets_country_api()
    {
        $this->getCountriesApi()->shouldReturnAnInstanceOf(Api\CountriesApiInterface::class);
    }
    
    public function if_gets_currencies_api()
    {
        $this->getCurrenciesApi()->shouldReturnAnInstanceOf(Api\CurrenciesApiInterface::class);
    }
    
    public function if_gets_customers_api()
    {
        $this->getCustomersApi()->shouldReturnAnInstanceOf(Api\CustomersApiInterface::class);
    }

    public function if_gets_exchangeRates_api()
    {
        $this->getExchangeRatesApi()->shouldReturnAnInstanceOf(Api\ExchangeRatesApiInterface::class);
    }

    public function if_gets_locales_api()
    {
        $this->getLocalesApi()->shouldReturnAnInstanceOf(Api\LocalesApiInterface::class);
    }

    public function if_gets_orders_api()
    {
        $this->getOrdersApi()->shouldReturnAnInstanceOf(Api\OrdersApiInterface::class);
    }

    public function if_gets_paymentMethods_api()
    {
        $this->getPaymentMethodsApi()->shouldReturnAnInstanceOf(Api\PaymentMethodsApiInterface::class);
    }

    public function if_gets_payments_api()
    {
        $this->getPaymentsApi()->shouldReturnAnInstanceOf(Api\PaymentsApiInterface::class);
    }

    public function if_gets_products_api()
    {
        $this->getProductsApi()->shouldReturnAnInstanceOf(Api\ProductsApiInterface::class);
    }

    public function if_gets_productAttributes_api()
    {
        $this->getProductAttributesApi()->shouldReturnAnInstanceOf(Api\ProductAttributesApiInterface::class);
    }

    public function if_gets_productAssociationTypes_api()
    {
        $this->getProductAssociationTypesApi()->shouldReturnAnInstanceOf(Api\ProductAssociationTypesApiInterface::class);
    }

    public function if_gets_productOptions_api()
    {
        $this->getProductOptionsApi()->shouldReturnAnInstanceOf(Api\ProductOptionsApiInterface::class);
    }

    public function if_gets_productReviews_api()
    {
        $this->getProductReviewsApi()->shouldReturnAnInstanceOf(Api\ProductReviewsApiInterface::class);
    }

    public function if_gets_productVariants_api()
    {
        $this->getProductVariantsApi()->shouldReturnAnInstanceOf(Api\ProductVariantsApiInterface::class);
    }

    public function if_gets_promotions_api()
    {
        $this->getPromotionsApi()->shouldReturnAnInstanceOf(Api\PromotionsApiInterface::class);
    }

    public function if_gets_promotionCoupons_api()
    {
        $this->getPromotionCouponsApi()->shouldReturnAnInstanceOf(Api\PromotionCouponsApiInterface::class);
    }

    public function if_gets_shipments_api()
    {
        $this->getShipmentsApi()->shouldReturnAnInstanceOf(Api\ShipmentsApiInterface::class);
    }

    public function if_gets_shippingCategories_api()
    {
        $this->getShippingCategoriesApi()->shouldReturnAnInstanceOf(Api\ShippingCategoriesApiInterface::class);
    }

    public function if_gets_taxCategories_api()
    {
        $this->getTaxCategoriesApi()->shouldReturnAnInstanceOf(Api\TaxCategoriesApiInterface::class);
    }

    public function if_gets_taxRates_api()
    {
        $this->getTaxRatesApi()->shouldReturnAnInstanceOf(Api\TaxRatesApiInterface::class);
    }

    public function if_gets_taxons_api()
    {
        $this->getTaxonsApi()->shouldReturnAnInstanceOf(Api\TaxonsApiInterface::class);
    }

    public function if_gets_users_api()
    {
        $this->getUsersApi()->shouldReturnAnInstanceOf(Api\UsersApiInterface::class);
    }

    public function if_gets_zones_api()
    {
        $this->getZonesApi()->shouldReturnAnInstanceOf(Api\ZonesApiInterface::class);
    }
}
