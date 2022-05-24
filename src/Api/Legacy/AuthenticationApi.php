<?php declare(strict_types=1);
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 *
 * @category    SyliusApiClient
 *
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\Api\Legacy;

use Diglin\Sylius\ApiClient\Client\HttpClient;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;

/**
 * API implementation to manage the authentication.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @deprecated
 */
final class AuthenticationApi implements AuthenticationApiInterface
{
    public const TOKEN_URI = 'api/oauth/v2/token';

    public function __construct(
        private HttpClient $httpClient,
        private UriGeneratorInterface $uriGenerator
    ) {}

    /**
     * {@inheritdoc}
     */
    public function authenticateByPassword(string $clientId, string $secret, string $username, string $password): array
    {
        $requestBody = [
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
            'client_id' => $clientId,
            'client_secret' => $secret,
        ];

        return $this->authenticate($requestBody);
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateByRefreshToken(string $clientId, string $secret, string $refreshToken): array
    {
        $requestBody = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        return $this->authenticate($requestBody);
    }

    /**
     * Authenticates the client by requesting the access token and the refresh token.
     *
     * @param array $requestBody body of the request to authenticate
     *
     * @return array returns the body of the response containing access token and refresh token
     */
    protected function authenticate(array $requestBody)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $uri = $this->uriGenerator->generate(static::TOKEN_URI);

        $response = $this->httpClient->sendRequest('POST', $uri, $headers, json_encode($requestBody));

        return json_decode($response->getBody()->getContents(), true);
    }
}
