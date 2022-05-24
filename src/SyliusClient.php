<?php

declare(strict_types=1);

use Diglin\Sylius\ApiClient;

trigger_deprecation('diglin/sylius-api-php-client', '2.0', 'The "%s" class is deprecated, use "%s" instead.', 'Diglin\\Sylius\\ApiClient\\SyliusClient', ApiClient\SyliusLegacyClient::class);

/**
 * @deprecated since diglin/sylius-api-php-client 2.0, use Diglin\Sylius\ApiClient\ApiClient\SyliusLegacyClient instead.
 */
class_alias(ApiClient\SyliusLegacyClient::class, 'Diglin\\Sylius\\ApiClient\\SyliusClient');
