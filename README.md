# PHP Sylius PHP API client

A simple PHP client to use the [Sylius PHP API](https://docs.sylius.com/en/latest/api/).

*IMPORTANT:* Documentation is work in progress.

Compatibility matrix:

| Sylius version(s)  | API PHP Client version | PHP requirements |CI status                                                                                                                 |
|--------------------|------------------------|------------------|--------------------------------------------------------------------------------------------------------------------------|
| \>= 1.6 <=1.7      | ^1.0 (master)          | ^7.3             | |
| 1.8                | no support             |                  | |
| \>= 1.9            | ^2.0 (next)            | ^8.0             | |

Note that our PHP client is backward compatible.

## Usage for API v2 (Sylius >= 1.9)

In Sylius versions 1.9 and later, you will be using the v2 API, or Unified API.
This APU will expose 2 sections:
* the Shop API, for accessing data from the customer's point of view
* the Admin API, for accessing data from an administrator point of view

Additionally, you can activate the now deprecated v1 Admin API.

To create your client, there is a client builder for each API that will take care for
you of the internals and dependency injection.

### Admin API usage

```php
<?php

$builder = new \Diglin\Sylius\ApiClient\SyliusAdminClientBuilder();

$client = $builder->buildAuthenticatedByPassword('johndoe', 'password');
$client->getProductApi()->all();
```

### Store API usage

```php
<?php

$builder = new \Diglin\Sylius\ApiClient\SyliusStoreClientBuilder();

$client = $builder->buildAuthenticatedByPassword('johndoe@example.com', 'password');
$client->getProductApi()->all();
```

## Usage for API v1 (Sylius >= 1.6 <=1.7, deprecated after 1.7)

> NOTE: If you are using Sylius version >= 1.10, you will need to reactivate this API
> following this documentation: https://docs.sylius.com/en/1.10/book/api/introduction.html?highlight=sylius_api

To create your client, there is a client builder that will take care for
you of the internals and dependency injection.

```php
<?php

$builder = new \Diglin\Sylius\ApiClient\SyliusLegacyClientBuilder();

$client = $builder->buildAuthenticatedByPassword('johndoe', 'password', '<api key>', '<api secret>');
$client->getProductsApi()->all();
```

