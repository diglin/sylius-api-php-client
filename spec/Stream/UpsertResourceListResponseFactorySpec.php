<?php

namespace spec\Diglin\Sylius\ApiClient\Stream;

use Diglin\Sylius\ApiClient\Stream\LineStreamReader;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponse;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponseFactory;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\StreamInterface;

class UpsertResourceListResponseFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UpsertResourceListResponseFactory::class);
    }

    public function it_creates_an_upsert_resource_list_response(StreamInterface $stream)
    {
        $this->create($stream)->shouldBeLike(
            new UpsertResourceListResponse($stream->getWrappedObject(), new LineStreamReader())
        );
    }
}
