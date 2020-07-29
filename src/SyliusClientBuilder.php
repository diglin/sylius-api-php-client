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
use Diglin\Sylius\ApiClient\Api\AuthenticationApi;
use Diglin\Sylius\ApiClient\Api\CartsApi;
use Diglin\Sylius\ApiClient\Api\ChannelsApi;
use Diglin\Sylius\ApiClient\Api\CountriesApi;
use Diglin\Sylius\ApiClient\Api\CurrenciesApi;
use Diglin\Sylius\ApiClient\Api\CustomersApi;
use Diglin\Sylius\ApiClient\Api\ExchangeRatesApi;
use Diglin\Sylius\ApiClient\Api\LocalesApi;
use Diglin\Sylius\ApiClient\Api\OrdersApi;
use Diglin\Sylius\ApiClient\Api\PaymentMethodsApi;
use Diglin\Sylius\ApiClient\Api\PaymentsApi;
use Diglin\Sylius\ApiClient\Api\ProductAssociationTypesApi;
use Diglin\Sylius\ApiClient\Api\ProductAttributesApi;
use Diglin\Sylius\ApiClient\Api\ProductOptionsApi;
use Diglin\Sylius\ApiClient\Api\ProductReviewsApi;
use Diglin\Sylius\ApiClient\Api\ProductsApi;
use Diglin\Sylius\ApiClient\Api\ProductVariantsApi;
use Diglin\Sylius\ApiClient\Api\PromotionCouponsApi;
use Diglin\Sylius\ApiClient\Api\PromotionsApi;
use Diglin\Sylius\ApiClient\Api\ShipmentsApi;
use Diglin\Sylius\ApiClient\Api\ShippingCategoriesApi;
use Diglin\Sylius\ApiClient\Api\TaxCategoriesApi;
use Diglin\Sylius\ApiClient\Api\TaxonsApi;
use Diglin\Sylius\ApiClient\Api\TaxRatesApi;
use Diglin\Sylius\ApiClient\Api\UsersApi;
use Diglin\Sylius\ApiClient\Api\ZonesApi;
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
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;
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
class SyliusClientBuilder implements SyliusClientBuilderInterface
{
    /** @var string */
    protected $baseUri;

    /** @var Client */
    protected $httpClient;

    /** @var RequestFactory */
    protected $requestFactory;

    /** @var StreamFactory */
    protected $streamFactory;

    /** @var FileSystemInterface */
    protected $fileSystem;

    /** @var ApiAwareInterface[] */
    protected $apiRegistry = [];

    /** @var array */
    protected $defaultHeaders = [];

    public function __construct(?ApiAwareInterface ...$apis)
    {
        foreach ($apis as $api) {
            $this->addApi($api);
        }
    }

    /**
     * @return array
     */
    protected function setUp(Authentication $authentication)
    {
        $uriGenerator = new UriGenerator($this->baseUri);
        $httpClient = new HttpClient($this->getHttpClient(), $this->getRequestFactory(), $this->getStreamFactory(), $this->defaultHeaders);

        $authenticationApi = new AuthenticationApi($httpClient, $uriGenerator);
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

        return [$resourceClient, $pageFactory, $cursorFactory, $fileSystem];
    }

    public function addApi(ApiAwareInterface $api)
    {
        $this->apiRegistry[(new \ReflectionClass($api))->getShortName()] = $api;
    }

    public function setBaseUri(string $baseUri)
    {
        $this->baseUri = $baseUri;
    }

    public function setDefaultHeaders(array $headers)
    {
        $this->defaultHeaders = $headers;
    }

    /**
     * Allows to directly set a client instead of using HttpClientDiscovery::find().
     */
    public function setHttpClient(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Allows to directly set a request factory instead of using MessageFactoryDiscovery::find().
     */
    public function setRequestFactory(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * Allows to directly set a stream factory instead of using StreamFactoryDiscovery::find().
     */
    public function setStreamFactory(StreamFactory $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

    /**
     * Build the Sylius client authenticated by user name and password.
     */
    public function buildAuthenticatedByPassword(
        string $clientId,
        string $secret,
        string $username,
        string $password
    ): SyliusClientInterface {
        $authentication = Authentication::fromPassword($clientId, $secret, $username, $password);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the Sylius client authenticated by token.
     */
    public function buildAuthenticatedByToken(
        string $clientId,
        string $secret,
        string $token,
        string $refreshToken
    ): SyliusClientInterface {
        $authentication = Authentication::fromToken($clientId, $secret, $token, $refreshToken);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the Sylius client authenticated by HTTP header.
     */
    public function buildAuthenticatedByHeader(array $xAuthToken): SyliusClientInterface
    {
        $authentication = Authentication::fromXAuthToken($xAuthToken);

        return $this->buildAuthenticatedClient($authentication);
    }

    private function buildAuthenticatedClient(Authentication $authentication): SyliusClientInterface
    {
        [$resourceClient, $pageFactory, $cursorFactory, $fileSystem] = $this->setUp($authentication);

        $client = new SyliusClientDecorator(
            new SyliusClient(
                $authentication,
                new CartsApi($resourceClient, $pageFactory, $cursorFactory),
                new ChannelsApi($resourceClient, $pageFactory, $cursorFactory),
                new CountriesApi($resourceClient, $pageFactory, $cursorFactory),
                new CurrenciesApi($resourceClient, $pageFactory, $cursorFactory),
                new CustomersApi($resourceClient, $pageFactory, $cursorFactory),
                new ExchangeRatesApi($resourceClient, $pageFactory, $cursorFactory),
                new LocalesApi($resourceClient, $pageFactory, $cursorFactory),
                new OrdersApi($resourceClient, $pageFactory, $cursorFactory),
                new PaymentMethodsApi($resourceClient, $pageFactory, $cursorFactory),
                new PaymentsApi($resourceClient, $pageFactory, $cursorFactory),
                new ProductsApi($resourceClient, $pageFactory, $cursorFactory),
                new ProductAttributesApi($resourceClient, $pageFactory, $cursorFactory),
                new ProductAssociationTypesApi($resourceClient, $pageFactory, $cursorFactory),
                new ProductOptionsApi($resourceClient, $pageFactory, $cursorFactory),
                new ProductReviewsApi($resourceClient, $pageFactory, $cursorFactory),
                new ProductVariantsApi($resourceClient, $pageFactory, $cursorFactory),
                new PromotionsApi($resourceClient, $pageFactory, $cursorFactory),
                new PromotionCouponsApi($resourceClient, $pageFactory, $cursorFactory),
                new ShipmentsApi($resourceClient, $pageFactory, $cursorFactory),
                new ShippingCategoriesApi($resourceClient, $pageFactory, $cursorFactory),
                new TaxCategoriesApi($resourceClient, $pageFactory, $cursorFactory),
                new TaxRatesApi($resourceClient, $pageFactory, $cursorFactory),
                new TaxonsApi($resourceClient, $pageFactory, $cursorFactory),
                new UsersApi($resourceClient, $pageFactory, $cursorFactory),
                new ZonesApi($resourceClient, $pageFactory, $cursorFactory)
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
