<?php

namespace spec\Diglin\Sylius\ApiClient;

use Diglin\Sylius\ApiClient\Api\ChannelsApiInterface;
use Diglin\Sylius\ApiClient\Security\Authentication;
use Diglin\Sylius\ApiClient\SyliusClient;
use Diglin\Sylius\ApiClient\SyliusClientInterface;
use PhpSpec\ObjectBehavior;

class SyliusClientSpec extends ObjectBehavior
{
    public function let(
        Authentication $authentication,
        ChannelsApiInterface $channelApi
    ) {
        $this->beConstructedWith(
            $authentication,
            $channelApi
        );
    }

    public function it_is_initializable()
    {
        $this->shouldImplement(SyliusClientInterface::class);
        $this->shouldHaveType(SyliusClient::class);
    }

    public function it_gets_access_token($authentication)
    {
        $authentication->getAccessToken()->willReturn('foo');

        $this->getToken()->shouldReturn('foo');
    }

    public function it_gets_refresh_token($authentication)
    {
        $authentication->getRefreshToken()->willReturn('bar');

        $this->getRefreshToken()->shouldReturn('bar');
    }

    public function it_gets_channel_api($channelApi)
    {
        $this->getChannelsApi()->shouldReturn($channelApi);
    }
}
