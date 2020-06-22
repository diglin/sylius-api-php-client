<?php

namespace spec\Diglin\Sylius\ApiClient\Pagination;

use Diglin\Sylius\ApiClient\Pagination\Page;
use Diglin\Sylius\ApiClient\Pagination\PageInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursor;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorInterface;
use PhpSpec\ObjectBehavior;

class ResourceCursorSpec extends ObjectBehavior
{
    public function let(PageInterface $firstPage)
    {
        $this->beConstructedWith(10, $firstPage);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ResourceCursor::class);
        $this->shouldImplement(ResourceCursorInterface::class);
    }

    public function it_is_iterable($firstPage, Page $secondPage)
    {
        $this->shouldImplement('\Iterator');

        $firstPage->getItems()->willReturn([
            ['code' => 'foo'],
            ['code' => 'bar'],
        ]);
        $firstPage->hasNextPage()->willReturn(true);
        $firstPage->getNextPage()->willReturn($secondPage);

        $secondPage->getItems()->willReturn([
            ['code' => 'baz'],
            ['code' => 'foz'],
        ]);
        $secondPage->hasNextPage()->willReturn(false);

        // methods that not iterate can be called twice
        $this->rewind()->shouldReturn(null);
        $this->valid()->shouldReturn(true);
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['code' => 'foo']);
        $this->current()->shouldReturn(['code' => 'foo']);
        $this->key()->shouldReturn(0);
        $this->key()->shouldReturn(0);

        // for each call sequence
        $this->rewind()->shouldReturn(null);
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['code' => 'foo']);
        $this->key()->shouldReturn(0);

        $this->next()->shouldReturn(null);
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['code' => 'bar']);
        $this->key()->shouldReturn(1);

        $this->next()->shouldReturn(null);
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['code' => 'baz']);
        $this->key()->shouldReturn(2);

        $this->next()->shouldReturn(null);
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['code' => 'foz']);
        $this->key()->shouldReturn(3);

        $this->next()->shouldReturn(null);
        $this->valid()->shouldReturn(false);

        // check that rewind is working
        $this->rewind()->shouldReturn(null);
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['code' => 'foo']);
        $this->key()->shouldReturn(0);
    }

    public function it_gets_page_size()
    {
        $this->getPageSize()->shouldReturn(10);
    }
}
