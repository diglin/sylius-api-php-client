<?php

namespace Diglin\Sylius\ApiClient;

interface SyliusShopClientBuilderInterface extends ClientBuilderInterface
{
    public function buildAuthenticatedByPassword(
        string $username,
        string $password
    ): SyliusShopClientInterface;

    public function buildAuthenticatedByToken(
        string $token,
    ): SyliusShopClientInterface;
}
