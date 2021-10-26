<?php

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;

interface SyliusShopClientInterface
{
    public function getAddressApi(): Api\Shop\AddressApiInterface;
    public function getAdjustmentApi(): Api\Shop\AdjustmentApiInterface;
    public function getChannelApi(): Api\Shop\ChannelApiInterface;
    public function getCountryApi(): Api\Shop\CountryApiInterface;
}
