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

class SyliusAdminClientBuilder implements SyliusAdminClientBuilderInterface
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
    ): SyliusAdminClientInterface {
        $authentication = Authentication::fromPassword($username, $password);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the Sylius client authenticated by token.
     */
    public function buildAuthenticatedByToken(
        string $token,
    ): SyliusAdminClientInterface {
        $authentication = Authentication::fromAccessToken($token);

        return $this->buildAuthenticatedClient($authentication);
    }

    private function buildAuthenticatedClient(Authentication $authentication): SyliusAdminClientInterface
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

        $client = new SyliusAdminClientDecorator(
            new SyliusAdminClient(
                $authentication,
                new Api\Admin\AddressApi($resourceClient),
                new Api\Admin\AdjustmentApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\AdministratorApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\AvatarImageApi($resourceClient),
                new Api\Admin\CatalogPromotionTranslationApi($resourceClient),
                new Api\Admin\CatalogPromotionApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ChannelApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ShopBillingDataApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\CountryApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProvinceApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\CurrencyApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\CustomerGroupApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\CustomerApi($resourceClient),
                new Api\Admin\ExchangeRateApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\LocaleApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\OrderItemUnitApi($resourceClient),
                new Api\Admin\OrderItemApi($resourceClient),
                new Api\Admin\OrderApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\PaymentApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ShipmentApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\PaymentMethodApi($resourceClient),
                new Api\Admin\ProductAssociationTypeTranslationApi($resourceClient),
                new Api\Admin\ProductAssociationTypeApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductImageApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductOptionTranslationApi($resourceClient),
                new Api\Admin\ProductOptionValueApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductOptionApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductReviewApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductTaxonApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductTranslationApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductVariantTranslationApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductVariantApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ProductApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\PromotionApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ShippingCategoryApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ShippingMethodTranslationApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ShippingMethodApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\TaxCategoryApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\TaxonTranslationApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\TaxonApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ZoneMemberApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ZoneApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\VerifyCustomerAccountApi($resourceClient, $pageFactory, $cursorFactory),
                new Api\Admin\ResetPasswordRequestApi($resourceClient, $pageFactory, $cursorFactory),
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
