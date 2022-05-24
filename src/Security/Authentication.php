<?php

namespace Diglin\Sylius\ApiClient\Security;

use Diglin\Sylius\ApiClient\Api;

/**
 * Credential data to authenticate to the API.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Authentication
{
    private ?string $username = null;
    private ?string $password = null;
    private ?string $accessToken = null;

    public static function fromPassword(string $username, string $password): self
    {
        $authentication = new static();
        $authentication->username = $username;
        $authentication->password = $password;

        return $authentication;
    }

    public static function fromAccessToken(string $accessToken): self
    {
        $authentication = new static();
        $authentication->accessToken = $accessToken;

        return $authentication;
    }

    public function authenticateByPassword(
        Api\Authentication\AuthenticationApiInterface $api
    ): self {
        $result = $api->authenticateByPassword($this->username, $this->password);

        $this->accessToken = $result['token'];

        return $this;
    }

    public function appendHeaders(array $headers): array
    {
        return array_merge(
            $headers,
            [
                'Authorization' => sprintf('Bearer %s', $this->accessToken),
            ]
        );
    }

    public function hasAccessToken(): bool
    {
        return $this->accessToken !== null;
    }

    public function clearAccessToken(): self
    {
        $this->accessToken = null;

        return $this;
    }
}
