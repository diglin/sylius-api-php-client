<?php

declare(strict_types=1);

use Diglin\Sylius\ApiClient;

trigger_deprecation('diglin/sylius-api-php-client', '2.0', 'The "%s" class is deprecated, use "%s" instead.', 'Diglin\\Sylius\\ApiClient\\SyliusClientBuilder', ApiClient\SyliusLegacyClientFactory::class);

/**
 * @deprecated since diglin/sylius-api-php-client 2.0, use Diglin\Sylius\ApiClient\ApiClient\SyliusLegacyClientBuilder instead.
 */
class_alias(ApiClient\SyliusLegacyClientFactory::class, 'Diglin\\Sylius\\ApiClient\\SyliusClientBuilder');
