<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 *
 * @category    SyliusApiClient
 *
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\Api;

use Diglin\Sylius\ApiClient\Client\HttpClient;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;

/**
 * API implementation to manage the authentication.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AuthenticationApi implements AuthenticationApiInterface
{
    public const TOKEN_URI = 'api/v2/admin/authentication-token';

    /** @var HttpClient */
    protected $httpClient;

    /** @var UriGeneratorInterface */
    protected $uriGenerator;

    public function __construct(HttpClient $httpClient, UriGeneratorInterface $uriGenerator)
    {
        $this->httpClient = $httpClient;
        $this->uriGenerator = $uriGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateByPassword($clientId, $secret, $username, $password)
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
    public function authenticateByRefreshToken($clientId, $secret, $refreshToken)
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
