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

namespace Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api\ApiAwareInterface;
use Diglin\Sylius\ApiClient\Api\Legacy as Api;
use Diglin\Sylius\ApiClient\Client\AuthenticatedHttpClient;
use Diglin\Sylius\ApiClient\Client\HttpClient;
use Diglin\Sylius\ApiClient\Client\ResourceClient;
use Diglin\Sylius\ApiClient\FileSystem\FileSystemInterface;
use Diglin\Sylius\ApiClient\FileSystem\LocalFileSystem;
use Diglin\Sylius\ApiClient\Pagination\PageFactory;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactory;
use Diglin\Sylius\ApiClient\Routing\UriGenerator;
use Diglin\Sylius\ApiClient\Security\LegacyAuthentication;
use Diglin\Sylius\ApiClient\Stream\MultipartStreamBuilderFactory;
use Diglin\Sylius\ApiClient\Stream\PatchResourceListResponseFactory;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponseFactory;
use Http\Client\HttpClient as Client;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Builder of the class SyliusClient.
 * This builder is in charge to instantiate and inject the dependencies.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @author    Sylvain Rayé <support@diglin.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SyliusLegacyClientFactory implements SyliusLegacyClientBuilderInterface
{
    private ?string $baseUri;
    private Client $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private FileSystemInterface $fileSystem;
    /** @var list<ApiAwareInterface> */
    private array $apiRegistry = [];
    private array $defaultHeaders = [];

    public function __construct(?ApiAwareInterface ...$apis)
    {
        foreach ($apis as $api) {
            $this->addApi($api);
        }
    }

    /**
     * @return array
     */
    protected function setUp(LegacyAuthentication $authentication)
    {
        $uriGenerator = new UriGenerator($this->baseUri);
        $httpClient = new HttpClient($this->getHttpClient(), $this->getRequestFactory(), $this->getStreamFactory(), $this->defaultHeaders);

        $authenticationApi = new Api\AuthenticationApi($httpClient, $uriGenerator);
        $authenticatedHttpClient = new AuthenticatedHttpClient($httpClient, $authenticationApi, $authentication);
        $multipartStreamBuilderFactory = new MultipartStreamBuilderFactory($this->getStreamFactory());
        $upsertListResponseFactory = new UpsertResourceListResponseFactory();
        $patchListResponseFactory = new PatchResourceListResponseFactory();

        $resourceClient = new ResourceClient(
            $authenticatedHttpClient,
            $uriGenerator,
            $multipartStreamBuilderFactory,
            $upsertListResponseFactory,
            $patchListResponseFactory,
        );

        $pageFactory = new PageFactory($authenticatedHttpClient, $uriGenerator);
        $cursorFactory = new ResourceCursorFactory();
        $fileSystem = null !== $this->fileSystem ? $this->fileSystem : new LocalFileSystem();

        return [$resourceClient, $pageFactory, $cursorFactory, $fileSystem];
    }

    public function addApi(ApiAwareInterface $api)
    {
        $this->apiRegistry[(new \ReflectionClass($api))->getShortName()] = $api;
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
        string $clientId,
        string $secret,
        string $username,
        string $password,
    ): SyliusLegacyClientInterface {
        $authentication = LegacyAuthentication::fromPassword($clientId, $secret, $username, $password);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the Sylius client authenticated by token.
     */
    public function buildAuthenticatedByToken(
        string $clientId,
        string $secret,
        string $token,
        string $refreshToken,
    ): SyliusLegacyClientInterface {
        $authentication = LegacyAuthentication::fromToken($clientId, $secret, $token, $refreshToken);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the Sylius client authenticated by HTTP header.
     */
    public function buildAuthenticatedByHeader(
        array $xAuthToken,
    ): SyliusLegacyClientInterface {
        $authentication = LegacyAuthentication::fromXAuthToken($xAuthToken);

        return $this->buildAuthenticatedClient($authentication);
    }

    private function buildAuthenticatedClient(
        LegacyAuthentication $authentication
    ): SyliusLegacyClientInterface {
        [$resourceClient, $pageFactory, $cursorFactory, $fileSystem] = $this->setUp($authentication);

        $client = new SyliusLegacyClientDecorator(
            new SyliusLegacyClient(
                $authentication,
                new Api\CartsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ChannelsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\CountriesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\CurrenciesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\CustomersApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ExchangeRatesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\LocalesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\OrdersApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\PaymentMethodsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\PaymentsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ProductsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ProductAttributesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ProductAssociationTypesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ProductOptionsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ProductReviewsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ProductVariantsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\PromotionsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\PromotionCouponsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ShipmentsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ShippingCategoriesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\TaxCategoriesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\TaxRatesApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\TaxonsApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\UsersApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\ZonesApi($resourceClient, $pageFactory, $cursorFactory)
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
