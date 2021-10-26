<?php

namespace Diglin\Sylius\ApiClient\Client;

use Diglin\Sylius\ApiClient\Exception\InvalidArgumentException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;
use Diglin\Sylius\ApiClient\Stream\MultipartStreamBuilderFactory;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponse;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponseFactory;
use Psr\Http\Message\ResponseInterface;
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
    public function __construct(
        private HttpClientInterface $httpClient,
        private UriGeneratorInterface $uriGenerator,
        private MultipartStreamBuilderFactory $multipartStreamBuilderFactory,
        private UpsertResourceListResponseFactory $upsertListResponseFactory
    ) {}

    public function getResources(
        string|\Stringable $uri,
        array $uriParameters = [],
        $limit = 10,
        array $queryParameters = [],
        FilterBuilderInterface $filterBuilder = null,
        SortBuilderInterface $sortBuilder = null
    ): iterable {
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

    public function getResource(
        string|\Stringable $uri,
        array $uriParameters = [],
        array $queryParameters = []
    ): array {
        $uri = $this->uriGenerator->generate($uri, $uriParameters, $queryParameters);
        $response = $this->httpClient->sendRequest('GET', $uri, ['Accept' => '*/*']);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createResource(
        string|\Stringable$uri,
        array $uriParameters = [],
        array $body = []
    ): int {
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

    public function createMultipartResource(
        string|\Stringable $uri,
        array $uriParameters = [],
        array $requestParts = []
    ): ResponseInterface {
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

    public function upsertResource(
        string|\Stringable $uri,
        array $uriParameters = [],
        array $body = []
    ): int {
        unset($body['_links']);

        $uri = $this->uriGenerator->generate($uri, $uriParameters);
        $response = $this->httpClient->sendRequest(
            'PUT',
            $uri,
            ['Content-Type' => 'application/json'],
            json_encode($body)
        );

        return $response->getStatusCode();
    }

    public function upsertResourceList(
        string|\Stringable $uri,
        array $uriParameters = [],
        array|StreamInterface $resources = []
    ): UpsertResourceListResponse {
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

    public function patchResource(
        string|\Stringable $uri,
        array $uriParameters = [],
        array $body = []
    ): int {
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

    public function patchResourceList(
        string|\Stringable $uri,
        array $uriParameters = [],
        array|StreamInterface $resources = []
    ): PatchResourceListResponse {
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

    public function deleteResource(
        string|\Stringable $uri,
        array $uriParameters = []
    ): int {
        $uri = $this->uriGenerator->generate($uri, $uriParameters);

        $response = $this->httpClient->sendRequest('DELETE', $uri);

        return $response->getStatusCode();
    }

    public function getStreamedResource(
        string|\Stringable $uri,
        array $uriParameters = []
    ): StreamInterface {
        $uri = $this->uriGenerator->generate($uri, $uriParameters);
        $response = $this->httpClient->sendRequest('GET', $uri, ['Accept' => '*/*']);

        return $response->getBody();
    }
}
