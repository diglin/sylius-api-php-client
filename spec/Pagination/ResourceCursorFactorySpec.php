<?php

namespace spec\Diglin\Sylius\ApiClient\Pagination;

use Diglin\Sylius\ApiClient\Pagination\PageInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursor;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactory;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactoryInterface;
use PhpSpec\ObjectBehavior;

class ResourceCursorFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ResourceCursorFactory::class);
        $this->shouldImplement(ResourceCursorFactoryInterface::class);
    }

    public function it_creates_a_resource_cursor(PageInterface $page)
    {
        $this->createCursor(10, $page)->shouldBeLike(
            new ResourceCursor(10, $page->getWrappedObject())
        );
    }
}
