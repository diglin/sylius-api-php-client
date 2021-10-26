<?php

declare(strict_types=1);

use Diglin\Sylius\ApiClient;

trigger_deprecation('diglin/sylius-api-php-client', '2.0', 'The "%s" interface is deprecated, use "%s" instead.', 'Diglin\\Sylius\\ApiClient\\SyliusClientInterface', ApiClient\SyliusLegacyClientInterface::class);

/**
 * @deprecated since diglin/sylius-api-php-client 2.0, use Diglin\Sylius\ApiClient\ApiClient\SyliusLegacyClientInterface instead.
 */
class_alias(ApiClient\SyliusLegacyClientInterface::class, 'Diglin\\Sylius\\ApiClient\\SyliusClientInterface');
