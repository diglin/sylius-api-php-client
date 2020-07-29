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
    public function setBaseUri(string $baseUri);

    public function setDefaultHeaders(array $headers);

    public function setHttpClient(Client $httpClient);

    public function setRequestFactory(RequestFactory $requestFactory);

    public function setStreamFactory(StreamFactory $streamFactory);

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
