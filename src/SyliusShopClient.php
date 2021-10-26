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
}
