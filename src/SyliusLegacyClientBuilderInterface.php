<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

interface SyliusLegacyClientBuilderInterface extends ClientBuilderInterface
{
    public function buildAuthenticatedByPassword(
        string $clientId,
        string $secret,
        string $username,
        string $password,
    ): SyliusLegacyClientInterface;

    public function buildAuthenticatedByToken(
        string $clientId,
        string $secret,
        string $token,
        string $refreshToken,
    ): SyliusLegacyClientInterface;

    /**
     * Build the Sylius client authenticated by HTTP header.
     */
    public function buildAuthenticatedByHeader(
        array $xAuthToken,
    ): SyliusLegacyClientInterface;
}
