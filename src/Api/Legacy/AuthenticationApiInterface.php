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

/**
 * API to manage the authentication.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @deprecated
 */
interface AuthenticationApiInterface
{
    /**
     * Authenticates with the password grant type.
     */
    public function authenticateByPassword(string $clientId, string $secret, string $username, string $password): array;

    /**
     * Authenticates with the refresh token grant type.
     */
    public function authenticateByRefreshToken(string $clientId, string $secret, string $refreshToken): array;
}
