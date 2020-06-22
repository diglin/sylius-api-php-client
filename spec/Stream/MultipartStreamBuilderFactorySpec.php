<?php

namespace spec\Diglin\Sylius\ApiClient\Stream;

use Diglin\Sylius\ApiClient\Stream\MultipartStreamBuilderFactory;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\StreamFactoryInterface;

class MultipartStreamBuilderFactorySpec extends ObjectBehavior
{
    public function let(StreamFactoryInterface $streamFactory)
    {
        $this->beConstructedWith($streamFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MultipartStreamBuilderFactory::class);
    }

    public function it_creates_a_multipart_stream_builder()
    {
        $this
            ->create()
            ->shouldReturnAnInstanceOf(MultipartStreamBuilder::class)
        ;
    }
}
