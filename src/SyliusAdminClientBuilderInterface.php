<?php

namespace Diglin\Sylius\ApiClient;

interface SyliusAdminClientBuilderInterface extends ClientBuilderInterface
{
    public function buildAuthenticatedByPassword(
        string $username,
        string $password
    ): SyliusAdminClientInterface;

    public function buildAuthenticatedByToken(
        string $token,
    ): SyliusAdminClientInterface;
}
