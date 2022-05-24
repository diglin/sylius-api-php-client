<?php

namespace Diglin\Sylius\ApiClient\Client;

use Diglin\Sylius\ApiClient\Api;
use Diglin\Sylius\ApiClient\Exception\UnauthorizedHttpException;
use Diglin\Sylius\ApiClient\Security\Authentication;
use Psr\Log\LoggerInterface;

/**
 * Http client to send an authenticated request.
 *
 * The authentication process is automatically handle by this client implementation.
 *
 * It enriches the request with an access token.
 * If the access token is expired, it will automatically refresh it.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AuthenticatedHttpClient implements HttpClientInterface
{
    public function __construct(
        private HttpClient $basicHttpClient,
        private Api\Authentication\AuthenticationApiInterface $authenticationApi,
        private Authentication $authentication,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function sendRequest($httpMethod, $uri, array $headers = [], $body = null)
    {
        try {
            if (!$this->authentication->hasAccessToken()) {
                $this->authentication->authenticateByPassword($this->authenticationApi);
            }

            $response = $this->basicHttpClient->sendRequest($httpMethod, $uri, $this->authentication->appendHeaders($headers), $body);
        } catch (UnauthorizedHttpException) {
            $this->authentication->authenticateByPassword($this->authenticationApi);
            $response = $this->basicHttpClient->sendRequest($httpMethod, $uri, $this->authentication->appendHeaders($headers), $body);
        }

        return $response;
    }
}
