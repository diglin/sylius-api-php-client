<?php declare(strict_types=1);

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api;
use Diglin\Sylius\ApiClient\Client\AuthenticatedHttpClient;
use Diglin\Sylius\ApiClient\Client\HttpClient;
use Diglin\Sylius\ApiClient\Client\ResourceClient;
use Diglin\Sylius\ApiClient\FileSystem\FileSystemInterface;
use Diglin\Sylius\ApiClient\FileSystem\LocalFileSystem;
use Diglin\Sylius\ApiClient\Pagination\PageFactory;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactory;
use Diglin\Sylius\ApiClient\Routing\UriGenerator;
use Diglin\Sylius\ApiClient\Security\Authentication;
use Diglin\Sylius\ApiClient\Stream\MultipartStreamBuilderFactory;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponseFactory;
use Http\Client\HttpClient as Client;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class SyliusShopClientBuilder implements SyliusShopClientBuilderInterface
{
    private string $baseUri;
    private Client $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private FileSystemInterface $fileSystem;
    /** @var list<Api\ApiAwareInterface> */
    private array $apiRegistry = [];
    /** @var array<string, string> */
    private array $defaultHeaders = [];

    public function __construct(Api\ApiAwareInterface ...$apis)
    {
        array_map(fn (Api\ApiAwareInterface $api) => $this->addApi($api), $apis);
    }

    public function addApi(Api\ApiAwareInterface $api): self
    {
        $this->apiRegistry[(new \ReflectionClass($api))->getShortName()] = $api;

        return $this;
    }

    public function setBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    public function setDefaultHeaders(array $headers): self
    {
        $this->defaultHeaders = $headers;

        return $this;
    }

    /**
     * Allows to directly set a client instead of using HttpClientDiscovery::find().
     */
    public function setHttpClient(Client $httpClient): self
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Allows to directly set a request factory instead of using MessageFactoryDiscovery::find().
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): self
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    /**
     * Allows to directly set a stream factory instead of using StreamFactoryDiscovery::find().
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): self
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }

    /**
     * Build the Sylius client authenticated by user name and password.
     */
    public function buildAuthenticatedByPassword(
        string $username,
        string $password
    ): SyliusShopClientInterface {
        $authentication = Authentication::fromPassword($username, $password);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the Sylius client authenticated by token.
     */
    public function buildAuthenticatedByToken(
        string $token,
    ): SyliusShopClientInterface {
        $authentication = Authentication::fromAccessToken($token);

        return $this->buildAuthenticatedClient($authentication);
    }

    private function buildAuthenticatedClient(Authentication $authentication): SyliusShopClientInterface
    {
        $uriGenerator = new UriGenerator($this->baseUri);
        $httpClient = new HttpClient($this->getHttpClient(), $this->getRequestFactory(), $this->getStreamFactory(), $this->defaultHeaders);

        $authenticationApi = new Api\Authentication\AdminApi($httpClient, $uriGenerator);
        $authenticatedHttpClient = new AuthenticatedHttpClient($httpClient, $authenticationApi, $authentication);
        $multipartStreamBuilderFactory = new MultipartStreamBuilderFactory($this->getStreamFactory());
        $upsertListResponseFactory = new UpsertResourceListResponseFactory();

        $resourceClient = new ResourceClient(
            $authenticatedHttpClient,
            $uriGenerator,
            $multipartStreamBuilderFactory,
            $upsertListResponseFactory
        );

        $pageFactory = new PageFactory($authenticatedHttpClient, $uriGenerator);
        $cursorFactory = new ResourceCursorFactory();
        $fileSystem = null !== $this->fileSystem ? $this->fileSystem : new LocalFileSystem();

        $client = new SyliusShopClientDecorator(
            new SyliusShopClient(
                $authentication,
                new Api\Shop\AddressApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Shop\AdjustmentApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Shop\ChannelApi($resourceClient),
                new Api\Shop\CountryApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Shop\CurrencyApi($resourceClient),
                new Api\Shop\CustomerApi($resourceClient),
                new Api\Shop\LocaleApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Shop\OrderItemUnitApi($resourceClient),
                new Api\Shop\OrderItemApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Shop\OrderApi($resourceClient, $pageFactory, $cursorFactory),
            )
        );

        foreach ($this->apiRegistry as $key => $api) {
            $api->setResourceClient($resourceClient);
            $api->setPageFactory($pageFactory);
            $api->setCursorFactory($cursorFactory);
            $api->setFileSystem($fileSystem);

            $client->addApi($key, $api);
        }

        return $client;
    }

    private function getHttpClient(): Client
    {
        if (null === $this->httpClient) {
            $this->httpClient = HttpClientDiscovery::find();
        }

        return $this->httpClient;
    }

    private function getRequestFactory(): RequestFactoryInterface
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }

        return $this->requestFactory;
    }

    private function getStreamFactory(): StreamFactoryInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $this->streamFactory;
    }
}
