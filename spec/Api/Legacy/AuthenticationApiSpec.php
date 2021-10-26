<?php

namespace spec\Diglin\Sylius\ApiClient\Api\Legacy;

use Diglin\Sylius\ApiClient\Api\Legacy\AuthenticationApi;
use Diglin\Sylius\ApiClient\Api\Legacy\AuthenticationApiInterface;
use Diglin\Sylius\ApiClient\Client\HttpClient;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class AuthenticationApiSpec extends ObjectBehavior
{
    public function let(HttpClient $httpClient, UriGeneratorInterface $uriGenerator)
    {
        $this->beConstructedWith($httpClient, $uriGenerator);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AuthenticationApi::class);
        $this->shouldImplement(AuthenticationApiInterface::class);
    }

    public function it_authenticates_with_the_password_grant_type(
        $uriGenerator,
        $httpClient,
        ResponseInterface $response,
        StreamInterface $body
    ) {
        $uriGenerator->generate(AuthenticationApi::TOKEN_URI)->willReturn('http://diglin.com/api/oauth/v2/token');
        $httpClient->sendRequest(
            'POST',
            'http://diglin.com/api/oauth/v2/token',
            [
                'Content-Type' => 'application/json',
            ],
            '{"grant_type":"password","username":"julia","password":"julia_pwd","client_id":"client_id","client_secret":"secret"}'
        )->willReturn($response);

        $response->getBody()->willReturn($body);
        $responseContent = <<<'JSON'
            {
                "access_token": "foo",
                "expires_in": 3600,
                "token_type": "bearer",
                "scope": null,
                "refresh_token": "bar"
            }
            JSON;
        $body->getContents()->willReturn($responseContent);

        $this->authenticateByPassword('client_id', 'secret', 'julia', 'julia_pwd')->shouldReturn([
            'access_token' => 'foo',
            'expires_in' => 3600,
            'token_type' => 'bearer',
            'scope' => null,
            'refresh_token' => 'bar',
        ]);
    }

    public function it_authenticates_with_the_refresh_token_type(
        $uriGenerator,
        $httpClient,
        ResponseInterface $response,
        StreamInterface $body
    ) {
        $uriGenerator->generate(AuthenticationApi::TOKEN_URI)->willReturn('http://diglin.com/api/oauth/v2/token');
        $httpClient->sendRequest(
            'POST',
            'http://diglin.com/api/oauth/v2/token',
            [
                'Content-Type' => 'application/json',
            ],
            '{"grant_type":"refresh_token","refresh_token":"bar"}'
        )->willReturn($response);

        $response->getBody()->willReturn($body);
        $responseContent = <<<'JSON'
            {
                "access_token": "foo",
                "expires_in": 3600,
                "token_type": "bearer",
                "scope": null,
                "refresh_token": "baz"
            }
            JSON;
        $body->getContents()->willReturn($responseContent);

        $this->authenticateByRefreshToken('client_id', 'secret', 'bar')->shouldReturn([
            'access_token' => 'foo',
            'expires_in' => 3600,
            'token_type' => 'bearer',
            'scope' => null,
            'refresh_token' => 'baz',
        ]);
    }
}
