<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;
use Diglin\Sylius\ApiClient\Security\Authentication;
use phpDocumentor\Reflection\Utils;

class SyliusShopClient implements SyliusShopClientInterface
{
    public function __construct(
        private Authentication $authentication,
        private Api\Shop\AddressApiInterface $addressApi,
        private Api\Shop\AdjustmentApiInterface $adjustmentApi,
        private Api\Shop\ChannelApiInterface $channelApi,
        private Api\Shop\CountryApiInterface $countryApi,
        private Api\Shop\CurrencyApiInterface $currencyApi,
        private Api\Shop\CustomerApiInterface $customerApi,
        private Api\Shop\LocaleApiInterface $localeApi,
        private Api\Shop\OrderItemUnitApiInterface $orderItemUnitApi,
        private Api\Shop\OrderItemApiInterface $orderItemApi,
        private Api\Shop\OrderApiInterface $orderApi,
    ) {}

    public function getAddressApi(): Api\Shop\AddressApiInterface
    {
        return $this->addressApi;
    }

    public function getAdjustmentApi(): Api\Shop\AdjustmentApiInterface
    {
        return $this->adjustmentApi;
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
}
