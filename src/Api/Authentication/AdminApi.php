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

namespace Diglin\Sylius\ApiClient\Api\Authentication;

use Diglin\Sylius\ApiClient\Client\HttpClient;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;

/**
 * API implementation to manage the authentication.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AdminApi implements AuthenticationApiInterface
{
    public const TOKEN_URI = 'api/v2/admin/authentication-token';

    public function __construct(
        private HttpClient $httpClient,
        private UriGeneratorInterface $uriGenerator
    ) {}

    public function authenticateByPassword(string $username, string $password): array
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $uri = $this->uriGenerator->generate(static::TOKEN_URI);

        $response = $this->httpClient->sendRequest('POST', $uri, $headers, json_encode([
            'email' => $username,
            'password' => $password,
        ]));

        return json_decode($response->getBody()->getContents(), true);
    }
}
