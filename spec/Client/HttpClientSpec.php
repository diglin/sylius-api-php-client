<?php

namespace spec\Diglin\Sylius\ApiClient\Client;

use Diglin\Sylius\ApiClient\Client\HttpClientInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;
use Http\Client\HttpClient;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class HttpClientSpec extends ObjectBehavior
{
    public function let(
        HttpClient $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->beConstructedWith($httpClient, $requestFactory, $streamFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\Diglin\Sylius\ApiClient\Client\HttpClient::class);
        $this->shouldImplement(HttpClientInterface::class);
    }

    public function it_sends_a_successful_request(
        $requestFactory,
        $httpClient,
        $streamFactory,
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $requestFactory->createRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
        )->willReturn($request);

        $streamFactory->createStream(
            '{"identifier": "foo"}'
        )->willReturn($stream);

        $request->withBody($stream)->willReturn($request);
        $request->withAddedHeader('Content-Type', 'application/json')->willReturn($request);

        $httpClient->sendRequest($request)->willReturn($response);

        $this->sendRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
            ['Content-Type' => 'application/json'],
            '{"identifier": "foo"}'
        )->shouldReturn($response);
    }

    public function it_throws_an_exception_when_failing_request(
        $requestFactory,
        $httpClient,
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $responseBody
    ) {
        $requestFactory->createRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
//            ['Content-Type' => 'application/json'],
//            '{"identifier": "foo"}'
        )->willReturn($request);

        $httpClient->sendRequest($request)->willReturn($response);

        $response->getStatusCode()->willReturn(500);
        $response->getBody()->willReturn($responseBody);
        $responseBody->getContents()->willReturn('{"code": 500, "message": "Internal error."}');
        $responseBody->rewind()->shouldBeCalled();

        $this
            ->shouldThrow(HttpException::class)
            ->during('sendRequest', [
                'POST',
                'http://diglin.com/api/rest/v1/products/foo',
                ['Content-Type' => 'application/json'],
                '{"identifier": "foo"}',
            ])
        ;
    }
}
