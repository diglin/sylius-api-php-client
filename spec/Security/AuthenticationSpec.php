<?php

namespace spec\Diglin\Sylius\ApiClient\Security;

use PhpSpec\ObjectBehavior;

class AuthenticationSpec extends ObjectBehavior
{
    public function it_is_initializable_from_a_password()
    {
        $this->beConstructedThrough('fromPassword', ['client_id', 'secret', 'Julia', 'Julia_pwd']);
        $this->shouldHaveType('Diglin\Sylius\ApiClient\Security\Authentication');

        $this->getUsername()->shouldReturn('Julia');
        $this->getPassword()->shouldReturn('Julia_pwd');
        $this->getAccessToken()->shouldReturn(null);
        $this->getRefreshToken()->shouldReturn(null);
    }

    public function it_is_initializable_from_a_token()
    {
        $this->beConstructedThrough('fromToken', ['client_id', 'secret', 'token', 'refresh_token']);
        $this->shouldHaveType('Diglin\Sylius\ApiClient\Security\Authentication');

        $this->getClientId()->shouldReturn('client_id');
        $this->getSecret()->shouldReturn('secret');
        $this->getUsername()->shouldReturn(null);
        $this->getPassword()->shouldReturn(null);
        $this->getAccessToken()->shouldReturn('token');
        $this->getRefreshToken()->shouldReturn('refresh_token');
    }
}
