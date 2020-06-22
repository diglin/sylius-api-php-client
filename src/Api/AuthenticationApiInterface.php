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

/**
 * API to manage the authentication.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface AuthenticationApiInterface
{
    /**
     * Authenticates with the password grant type.
     *
     * @param string $clientId
     * @param string $secret
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function authenticateByPassword($clientId, $secret, $username, $password);

    /**
     * Authenticates with the refresh token grant type.
     *
     * @param string $clientId
     * @param string $secret
     * @param string $refreshToken
     *
     * @return array
     */
    public function authenticateByRefreshToken($clientId, $secret, $refreshToken);
}
