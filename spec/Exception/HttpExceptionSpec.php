<?php

namespace spec\Diglin\Sylius\ApiClient\Exception;

use Diglin\Sylius\ApiClient\Exception\ExceptionInterface;
use Diglin\Sylius\ApiClient\Exception\HttpException;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpExceptionSpec extends ObjectBehavior
{
    public function let(RequestInterface $request, ResponseInterface $response)
    {
        $this->beConstructedWith('message', $request, $response);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(HttpException::class);
        $this->shouldImplement(ExceptionInterface::class);
    }

    public function it_exposes_the_status_code_of_the_response($response)
    {
        $response->getStatusCode()->willReturn(200);
        $this->getCode()->shouldReturn(200);
    }

    public function it_exposes_the_response($response)
    {
        $this->getResponse()->shouldReturn($response);
    }

    public function it_exposes_the_request($request)
    {
        $this->getRequest()->shouldReturn($request);
    }
}
