<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    FWG OroCRM
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient;

use Http\Client\HttpClient as Client;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;

interface SyliusClientBuilderInterface
{
    public function setBaseUri(string $baseUri): self;

    public function setDefaultHeaders(array $headers): self;

    public function setHttpClient(Client $httpClient): self;

    public function setRequestFactory(RequestFactory $requestFactory): self;

    public function setStreamFactory(StreamFactory $streamFactory): self;

    public function buildAuthenticatedByPassword(
        string $clientId,
        string $secret,
        string $username,
        string $password
    ): SyliusClientInterface;

    public function buildAuthenticatedByToken(
        string $clientId,
        string $secret,
        string $token,
        string $refreshToken
    ): SyliusClientInterface;

    public function buildAuthenticatedByHeader(array $xAuthToken): SyliusClientInterface;
}
