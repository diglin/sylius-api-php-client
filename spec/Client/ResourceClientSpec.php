<?php

namespace spec\Diglin\Sylius\ApiClient\Client;

use Diglin\Sylius\ApiClient\Client\HttpClient;
use Diglin\Sylius\ApiClient\Client\ResourceClient;
use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Diglin\Sylius\ApiClient\Exception\InvalidArgumentException;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;
use Diglin\Sylius\ApiClient\Stream\MultipartStreamBuilderFactory;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponse;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponseFactory;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResourceClientSpec extends ObjectBehavior
{
    public function let(
        HttpClient $httpClient,
        UriGeneratorInterface $uriGenerator,
        MultipartStreamBuilderFactory $multipartStreamBuilderFactory,
        UpsertResourceListResponseFactory $responseFactory
    ) {
        $this->beConstructedWith($httpClient, $uriGenerator, $multipartStreamBuilderFactory, $responseFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldImplement(ResourceClientInterface::class);
        $this->shouldHaveType(ResourceClient::class);
    }

    public function it_gets_resource($httpClient, $uriGenerator, ResponseInterface $response, StreamInterface $responseBody)
    {
        $uri = 'http://diglin.com/api/rest/v1/categories/winter_collection';
        $resource =
<<<'JSON'
    {
        "code": "winter_collection",
        "parent": null,
        "labels": {
            "en_US": "Winter collection",
            "fr_FR": "Collection hiver"
        }
    }
    JSON;

        $uriGenerator
            ->generate('api/rest/v1/categories/%s', ['winter_collection'], [])
            ->willReturn($uri)
        ;

        $httpClient
            ->sendRequest('GET', $uri, ['Accept' => '*/*'])
            ->willReturn($response)
        ;

        $response
            ->getBody()
            ->willReturn($responseBody)
        ;

        $responseBody
            ->getContents()
            ->willReturn($resource)
        ;

        $this->getResource('api/rest/v1/categories/%s', ['winter_collection'], [])->shouldReturn([
            'code' => 'winter_collection',
            'parent' => null,
            'labels' => [
                'en_US' => 'Winter collection',
                'fr_FR' => 'Collection hiver',
            ],
        ]);
    }

    public function it_returns_a_page_when_requesting_a_list_of_resources(
        $httpClient,
        $uriGenerator,
        ResponseInterface $response,
        StreamInterface $responseBody
    ) {
        $uri = 'http://diglin.com/api/rest/v1/categories?limit=10&with_count=15&foo=bar';
        $resources = $this->getSampleOfResources();

        $uriGenerator
            ->generate('api/rest/v1/categories', [], ['foo' => 'bar', 'limit' => 10, 'with_count' => true])
            ->willReturn($uri)
        ;

        $httpClient
            ->sendRequest('GET', $uri, ['Accept' => '*/*'])
            ->willReturn($response)
        ;

        $response
            ->getBody()
            ->willReturn($responseBody)
        ;

        $responseBody
            ->getContents()
            ->willReturn(json_encode($resources))
        ;

        $this->getResources('api/rest/v1/categories', [], 10, ['foo' => 'bar'])->shouldReturn($resources);
    }

    public function it_returns_a_list_of_resources_without_limit_and_count(
        $httpClient,
        $uriGenerator,
        ResponseInterface $response,
        StreamInterface $responseBody
    ) {
        $uri = 'http://diglin.com/api/rest/v1/categories?foo=bar';
        $resources = $this->getSampleOfResources();

        $uriGenerator
            ->generate('api/rest/v1/categories', [], ['foo' => 'bar'])
            ->willReturn($uri)
        ;

        $httpClient
            ->sendRequest('GET', $uri, ['Accept' => '*/*'])
            ->willReturn($response)
        ;

        $response
            ->getBody()
            ->willReturn($responseBody)
        ;

        $responseBody
            ->getContents()
            ->willReturn(json_encode($resources))
        ;

        $this->getResources('api/rest/v1/categories', [], null, ['foo' => 'bar'])->shouldReturn($resources);
    }

    public function it_creates_a_resource(
        $httpClient,
        $uriGenerator,
        ResponseInterface $response
    ) {
        $uri = 'http://diglin.com/api/rest/v1/categories';

        $uriGenerator
            ->generate('api/rest/v1/categories', [])
            ->willReturn($uri)
        ;

        $response
            ->getStatusCode()
            ->willReturn(201)
        ;

        $httpClient
            ->sendRequest('POST', $uri, ['Content-Type' => 'application/json'], '{"code":"master"}')
            ->willReturn($response)
        ;

        $this->createResource(
            'api/rest/v1/categories',
            [],
            [
                '_links' => [
                    'self' => [
                        'href' => 'http://diglin.com/self',
                    ],
                ],
                'code' => 'master',
            ]
        );
    }

    public function it_upserts_a_resource(
        $httpClient,
        $uriGenerator,
        ResponseInterface $response
    ) {
        $uri = 'http://diglin.com/api/rest/v1/categories/master';

        $uriGenerator
            ->generate('api/rest/v1/categories/%s', ['master'])
            ->willReturn($uri)
        ;

        $httpClient
            ->sendRequest('PATCH', $uri, ['Content-Type' => 'application/json'], '{"parent":"foo"}')
            ->willReturn($response)
        ;

        $response
            ->getStatusCode()
            ->willReturn(201)
        ;

        $this
            ->upsertResource(
                'api/rest/v1/categories/%s',
                ['master'],
                [
                    '_links' => [
                        'self' => [
                            'href' => 'http://diglin.com/self',
                        ],
                    ],
                    'parent' => 'foo',
                ]
            )
            ->shouldReturn(201)
        ;
    }

    public function it_upserts_a_list_of_resources_from_an_array(
        $httpClient,
        $uriGenerator,
        $responseFactory,
        StreamInterface $responseBodyStream,
        UpsertResourceListResponse $listResponse,
        ResponseInterface $response
    ) {
        $uri = 'http://diglin.com/api/rest/v1/categories';

        $uriGenerator
            ->generate('api/rest/v1/categories', [])
            ->willReturn($uri)
        ;

        $body =
<<<'JSON'
    {"code":"category_1"}
    {"code":"category_2"}
    {"code":"category_3"}
    {"code":"category_4"}
    JSON;

        $httpClient
            ->sendRequest('PATCH', $uri, ['Content-Type' => 'application/vnd.akeneo.collection+json'], $body)
            ->shouldBeCalled()
            ->willReturn($response)
        ;

        $response
            ->getBody()
            ->willReturn($responseBodyStream)
        ;

        $responseFactory->create($responseBodyStream)->willReturn($listResponse);

        $this
            ->upsertResourceList(
                'api/rest/v1/categories',
                [],
                [
                    ['code' => 'category_1'],
                    ['code' => 'category_2'],
                    ['code' => 'category_3'],
                    ['code' => 'category_4'],
                ]
            )
            ->shouldReturn($listResponse)
        ;
    }

    public function it_upserts_a_list_of_resources_from_an_stream(
        $httpClient,
        $uriGenerator,
        $responseFactory,
        StreamInterface $responseBodyStream,
        StreamInterface $resourcesStream,
        UpsertResourceListResponse $listResponse,
        ResponseInterface $response
    ) {
        $uri = 'http://diglin.com/api/rest/v1/categories';

        $uriGenerator
            ->generate('api/rest/v1/categories', [])
            ->willReturn($uri)
        ;

        $httpClient
            ->sendRequest('PATCH', $uri, ['Content-Type' => 'application/vnd.akeneo.collection+json'], $resourcesStream)
            ->willReturn($response)
        ;

        $response
            ->getBody()
            ->willReturn($responseBodyStream)
        ;

        $responseFactory->create($responseBodyStream)->willReturn($listResponse);

        $this
            ->upsertResourceList('api/rest/v1/categories', [], $resourcesStream)
            ->shouldReturn($listResponse)
        ;
    }

    public function it_throws_an_exception_if_limit_is_defined_in_additional_parameters_to_get_resources()
    {
        $this
            ->shouldThrow(new InvalidArgumentException('The parameter "limit" should not be defined in the additional query parameters'))
            ->during('getResources', ['', [], null, ['limit' => null]])
        ;
    }

    public function it_throws_an_exception_if_resources_is_not_an_array_and_not_a_stream_when_upserting_a_list_of_resources()
    {
        $this
            ->shouldthrow(new InvalidArgumentException('The parameter "resources" must be an array or an instance of StreamInterface.'))
            ->during('upsertResourceList', ['api/rest/v1/categories', [], 'foo'])
        ;
    }

    public function it_creates_a_multipart_resource(
        $httpClient,
        $uriGenerator,
        $multipartStreamBuilderFactory,
        ResponseInterface $response,
        MultipartStreamBuilder $multipartStreamBuilder
    ) {
        $uri = 'http://diglin.com/api/rest/v1/media-files';
        $boundary = '59282643a51ca1.81601629';
        $product = '{"identifier":"foo","attribute":"picture","scope":"e-commerce","locale":"en_US"}';
        $fileResource = '42';
        $multipartStream = 'stream';
        $requestParts = [
            [
                'name' => 'product',
                'contents' => $product,
            ],
            [
                'name' => 'file',
                'contents' => $fileResource,
            ],
        ];

        $uriGenerator->generate('api/rest/v1/media-files', [])->willReturn($uri);

        $multipartStreamBuilderFactory->create()->willReturn($multipartStreamBuilder);

        $multipartStreamBuilder->build()->willReturn($multipartStream);
        $multipartStreamBuilder->addResource('product', $product, [])->shouldBeCalled();
        $multipartStreamBuilder->addResource('file', $fileResource, [])->shouldBeCalled();
        $multipartStreamBuilder->getBoundary()->willReturn($boundary);

        $headers = ['Content-Type' => sprintf('multipart/form-data; boundary="%s"', $boundary)];

        $response->getStatusCode()->willReturn(201);

        $httpClient
            ->sendRequest('POST', $uri, $headers, $multipartStream)
            ->willReturn($response)
        ;

        $this
            ->createMultipartResource('api/rest/v1/media-files', [], $requestParts)
            ->shouldReturn($response)
        ;
    }

    public function it_throws_an_exception_if_a_request_part_is_invalid_when_creating_a_multipart_resource(
        $multipartStreamBuilderFactory,
        MultipartStreamBuilder $multipartStreamBuilder
    ) {
        $multipartStreamBuilderFactory->create()->willReturn($multipartStreamBuilder);

        $this
            ->shouldThrow(new InvalidArgumentException('The keys "name" and "contents" must be defined for each request part'))
            ->during('createMultipartResource', [
                'api/rest/v1/media-files',
                [],
                [
                    [
                        'name' => 'product',
                        'contents' => 'foo',
                    ],
                    [
                        'name' => 'file',
                    ],
                ],
            ])
        ;

        $this
            ->shouldThrow(new InvalidArgumentException('The keys "name" and "contents" must be defined for each request part'))
            ->during('createMultipartResource', [
                'api/rest/v1/media-files',
                [],
                [
                    [
                        'name' => null,
                        'contents' => 'foo',
                    ],
                ],
            ])
        ;
    }

    public function it_deletes_a_resource(
        $httpClient,
        $uriGenerator,
        ResponseInterface $response
    ) {
        $uri = 'api/rest/v1/products/foo';

        $uriGenerator
            ->generate('api/rest/v1/products/%s', ['foo'])
            ->willReturn($uri)
        ;

        $httpClient
            ->sendRequest('DELETE', $uri)
            ->willReturn($response)
        ;

        $response
            ->getStatusCode()
            ->willReturn(204)
        ;

        $this
            ->deleteResource('api/rest/v1/products/%s', ['foo'])
            ->shouldReturn(204)
        ;
    }

    public function it_gets_a_streamed_resource(
        $httpClient,
        $uriGenerator,
        ResponseInterface $response,
        StreamInterface $responseBody
    ) {
        $uri = 'http://diglin.com/api/rest/v1/media-files/42.jpg/download';

        $uriGenerator
            ->generate('api/rest/v1/media-files/%s/download', ['42.jpg'])
            ->willReturn($uri)
        ;

        $httpClient->sendRequest('GET', $uri, ['Accept' => '*/*'])->willReturn($response);

        $response->getBody()->willReturn($responseBody);

        $this->getStreamedResource('api/rest/v1/media-files/%s/download', ['42.jpg'])->shouldReturn($responseBody);
    }

    protected function getSampleOfResources()
    {
        return [
            '_links' => [
                'self' => [
                    'href' => 'http://diglin.com/self',
                ],
                'first' => [
                    'href' => 'http://diglin.com/first',
                ],
                'previous' => [
                    'href' => 'http://diglin.com/previous',
                ],
                'next' => [
                    'href' => 'http://diglin.com/next',
                ],
            ],
            'items_count' => 10,
            '_embedded' => [
                'items' => [
                    ['identifier' => 'foo'],
                    ['identifier' => 'bar'],
                ],
            ],
        ];
    }
}
