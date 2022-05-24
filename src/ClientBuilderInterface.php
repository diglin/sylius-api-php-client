<?php

namespace Diglin\Sylius\ApiClient;

use Http\Client\HttpClient as Client;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/** @internal */
interface ClientBuilderInterface
{
    public function setBaseUri(string $baseUri): self;

    public function setDefaultHeaders(array $headers): self;

    public function setHttpClient(Client $httpClient): self;

    public function setRequestFactory(RequestFactoryInterface $requestFactory): self;

    public function setStreamFactory(StreamFactoryInterface $streamFactory): self;
}
