<?php

namespace spec\Diglin\Sylius\ApiClient\Client;

use Diglin\Sylius\ApiClient\Api\Legacy\AuthenticationApiInterface;
use Diglin\Sylius\ApiClient\Client\HttpClient;
use Diglin\Sylius\ApiClient\Client\HttpClientInterface;
use Diglin\Sylius\ApiClient\Client\LegacyAuthenticatedHttpClient;
use Diglin\Sylius\ApiClient\Exception\UnauthorizedHttpException;
use Diglin\Sylius\ApiClient\Security\LegacyAuthentication;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class LegacyAuthenticatedHttpClientSpec extends ObjectBehavior
{
    public function let(
        HttpClient $httpClient,
        AuthenticationApiInterface $authenticationApi,
        LegacyAuthentication $authentication
    ) {
        $this->beConstructedWith($httpClient, $authenticationApi, $authentication);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LegacyAuthenticatedHttpClient::class);
        $this->shouldImplement(HttpClientInterface::class);
    }

    public function it_sends_an_authenticated_and_successful_request_when_access_token_is_defined(
        $httpClient,
        $authentication,
        ResponseInterface $response
    ) {
        $authentication->getXauthtokenHeader()->willReturn(null);
        $authentication->getAccessToken()->willReturn('bar');

        $httpClient->sendRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
            ['Content-Type' => 'application/json', 'Authorization' => 'Bearer bar'],
            '{"identifier": "foo"}'
        )->willReturn($response);

        $this->sendRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
            ['Content-Type' => 'application/json'],
            '{"identifier": "foo"}'
        )->shouldReturn($response);
    }

    public function it_sends_an_authenticated_and_successful_request_at_first_call(
        $httpClient,
        $authenticationApi,
        $authentication,
        ResponseInterface $response
    ) {
        $authentication->getXauthtokenHeader()->willReturn(null);
        $authentication->getClientId()->willReturn('client_id');
        $authentication->getSecret()->willReturn('secret');
        $authentication->getUsername()->willReturn('julia');
        $authentication->getPassword()->willReturn('julia_pwd');
        $authentication->getAccessToken()->willReturn(null, 'foo');

        $authenticationApi
            ->authenticateByPassword('client_id', 'secret', 'julia', 'julia_pwd')
            ->willReturn([
                'access_token' => 'foo',
                'expires_in' => 3600,
                'token_type' => 'bearer',
                'scope' => null,
                'refresh_token' => 'bar',
            ])
        ;

        $authentication
            ->setAccessToken('foo')
            ->shouldBeCalled()
            ->willReturn($authentication)
        ;

        $authentication
            ->setRefreshToken('bar')
            ->shouldBeCalled()
            ->willReturn($authentication)
        ;

        $httpClient->sendRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
            ['Content-Type' => 'application/json', 'Authorization' => 'Bearer foo'],
            '{"identifier": "foo"}'
        )->willReturn($response);

        $this->sendRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
            ['Content-Type' => 'application/json'],
            '{"identifier": "foo"}'
        )->shouldReturn($response);
    }

    public function it_sends_an_authenticated_and_successful_request_when_access_token_expired(
        $httpClient,
        $authenticationApi,
        $authentication,
        ResponseInterface $response
    ) {
        $authentication->getXauthtokenHeader()->willReturn(null);
        $authentication->getClientId()->willReturn('client_id');
        $authentication->getSecret()->willReturn('secret');
        $authentication->getUsername()->willReturn('julia');
        $authentication->getPassword()->willReturn('julia_pwd');
        $authentication->getAccessToken()->willReturn('foo', 'foo', 'baz');
        $authentication->getRefreshToken()->willReturn('bar');

        $httpClient->sendRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
            ['Content-Type' => 'application/json', 'Authorization' => 'Bearer foo'],
            '{"identifier": "foo"}'
        )->willThrow(UnauthorizedHttpException::class);

        $authenticationApi
            ->authenticateByRefreshToken('client_id', 'secret', 'bar')
            ->willReturn([
                'access_token' => 'baz',
                'expires_in' => 3600,
                'token_type' => 'bearer',
                'scope' => null,
                'refresh_token' => 'foz',
            ])
        ;

        $authentication
            ->setAccessToken('baz')
            ->shouldBeCalled()
            ->willReturn($authentication)
        ;

        $authentication
            ->setRefreshToken('foz')
            ->shouldBeCalled()
            ->willReturn($authentication)
        ;

        $httpClient->sendRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
            ['Content-Type' => 'application/json', 'Authorization' => 'Bearer baz'],
            '{"identifier": "foo"}'
        )->willReturn($response);

        $this->sendRequest(
            'POST',
            'http://diglin.com/api/rest/v1/products/foo',
            ['Content-Type' => 'application/json'],
            '{"identifier": "foo"}'
        );
    }
}
