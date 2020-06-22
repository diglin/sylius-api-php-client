<?php

namespace Diglin\Sylius\ApiClient\Client;

use Diglin\Sylius\ApiClient\Exception\InvalidArgumentException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;
use Diglin\Sylius\ApiClient\Stream\MultipartStreamBuilderFactory;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponseFactory;
use Psr\Http\Message\StreamInterface;

/**
 * Generic client to execute common request on resources.
 *
 * @author    Laurent Petard <laurent.petard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ResourceClient implements ResourceClientInterface
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var UriGeneratorInterface */
    protected $uriGenerator;

    /** @var MultipartStreamBuilderFactory */
    protected $multipartStreamBuilderFactory;

    /** @var UpsertResourceListResponseFactory */
    protected $upsertListResponseFactory;

    public function __construct(
        HttpClientInterface $httpClient,
        UriGeneratorInterface $uriGenerator,
        MultipartStreamBuilderFactory $multipartStreamBuilderFactory,
        UpsertResourceListResponseFactory $upsertListResponseFactory
    ) {
        $this->httpClient = $httpClient;
        $this->uriGenerator = $uriGenerator;
        $this->multipartStreamBuilderFactory = $multipartStreamBuilderFactory;
        $this->upsertListResponseFactory = $upsertListResponseFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getResources(
        $uri,
        array $uriParameters = [],
        $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ) {
        if (array_key_exists('limit', $queryParameters)) {
            throw new InvalidArgumentException('The parameter "limit" should not be defined in the additional query parameters');
        }

        if (null !== $limit) {
            $queryParameters['limit'] = $limit;
        }

        if (null !== $filterBuilder) {
            $queryParameters = array_merge($queryParameters, $filterBuilder());
        }

        if (null !== $sortBuilder) {
            $queryParameters = array_merge($queryParameters, $sortBuilder());
        }

        return $this->getResource($uri, $uriParameters, $queryParameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getResource(
        $uri,
        array $uriParameters = [],
        array $queryParameters = []
    ) {
        $uri = $this->uriGenerator->generate($uri, $uriParameters, $queryParameters);
        $response = $this->httpClient->sendRequest('GET', $uri, ['Accept' => '*/*']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function createResource($uri, array $uriParameters = [], array $body = [])
    {
        unset($body['_links']);

        $uri = $this->uriGenerator->generate($uri, $uriParameters);
        $response = $this->httpClient->sendRequest(
            'POST',
            $uri,
            ['Content-Type' => 'application/json'],
            json_encode($body)
        );

        return $response->getStatusCode();
    }

    /**
     * {@inheritdoc}
     */
    public function createMultipartResource($uri, array $uriParameters = [], array $requestParts = [])
    {
        $streamBuilder = $this->multipartStreamBuilderFactory->create();

        foreach ($requestParts as $requestPart) {
            if (!isset($requestPart['name']) || !isset($requestPart['contents'])) {
                throw new InvalidArgumentException('The keys "name" and "contents" must be defined for each request part');
            }

            $options = $requestPart['options'] ?? [];
            $streamBuilder->addResource($requestPart['name'], $requestPart['contents'], $options);
        }

        $multipartStream = $streamBuilder->build();
        $boundary = $streamBuilder->getBoundary();
        $headers = ['Content-Type' => sprintf('multipart/form-data; boundary="%s"', $boundary)];
        $uri = $this->uriGenerator->generate($uri, $uriParameters);

        return $this->httpClient->sendRequest('POST', $uri, $headers, $multipartStream);
    }

    /**
     * {@inheritdoc}
     */
    public function upsertResource($uri, array $uriParameters = [], array $body = [])
    {
        unset($body['_links']);

        $uri = $this->uriGenerator->generate($uri, $uriParameters);
        $response = $this->httpClient->sendRequest(
            'PATCH',
            $uri,
            ['Content-Type' => 'application/json'],
            json_encode($body)
        );

        return $response->getStatusCode();
    }

    /**
     * {@inheritdoc}
     */
    public function upsertResourceList($uri, array $uriParameters = [], $resources = [])
    {
        if (!is_array($resources) && !$resources instanceof StreamInterface) {
            throw new InvalidArgumentException('The parameter "resources" must be an array or an instance of StreamInterface.');
        }

        if (is_array($resources)) {
            $body = '';
            $isFirstLine = true;
            foreach ($resources as $resource) {
                if (!is_array($resource)) {
                    throw new InvalidArgumentException('The parameter "resources" must be an array of array.');
                }
                unset($resource['_links']);
                $body .= ($isFirstLine ? '' : PHP_EOL).json_encode($resource);
                $isFirstLine = false;
            }
        } else {
            $body = $resources;
        }

        $uri = $this->uriGenerator->generate($uri, $uriParameters);
        $response = $this->httpClient->sendRequest(
            'PATCH',
            $uri,
            ['Content-Type' => 'application/json'],
            $body
        );

        return $this->upsertListResponseFactory->create($response->getBody());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteResource($uri, array $uriParameters = [])
    {
        $uri = $this->uriGenerator->generate($uri, $uriParameters);

        $response = $this->httpClient->sendRequest('DELETE', $uri);

        return $response->getStatusCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getStreamedResource($uri, array $uriParameters = [])
    {
        $uri = $this->uriGenerator->generate($uri, $uriParameters);
        $response = $this->httpClient->sendRequest('GET', $uri, ['Accept' => '*/*']);

        return $response->getBody();
    }
}
