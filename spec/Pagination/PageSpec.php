<?php

namespace spec\Diglin\Sylius\ApiClient\Pagination;

use Diglin\Sylius\ApiClient\Client\HttpClientInterface;
use Diglin\Sylius\ApiClient\Pagination\Page;
use Diglin\Sylius\ApiClient\Pagination\PageFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\PageInterface;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class PageSpec extends ObjectBehavior
{
    public function let(PageFactoryInterface $pageFactory, HttpClientInterface $httpClient)
    {
        $this->beConstructedWith(
            $pageFactory,
            $httpClient,
            'http://diglin.com/first',
            'http://diglin.com/previous',
            'http://diglin.com/next',
            10,
            [
                ['identifier' => 'foo'],
                ['identifier' => 'bar'],
            ]
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Page::class);
        $this->shouldImplement(PageInterface::class);
    }

    public function it_gets_next_page(
        $httpClient,
        $pageFactory,
        ResponseInterface $response,
        StreamInterface $stream,
        Page $nextPage
    ) {
        $nextPageContent = $this->getPageSample();
        $httpClient->sendRequest('GET', 'http://diglin.com/next', ['Accept' => '*/*'])->willReturn($response);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn(json_encode($nextPageContent));
        $pageFactory->createPage($nextPageContent)->willReturn($nextPage);

        $this->getNextPage()->shouldReturn($nextPage);
    }

    public function it_returns_null_when_getting_nonexistent_next_page($httpClient, $pageFactory)
    {
        $this->beConstructedWith(
            $pageFactory,
            $httpClient,
            'http://diglin.com/first',
            'http://diglin.com/previous',
            null,
            10,
            [
                ['identifier' => 'foo'],
                ['identifier' => 'bar'],
            ]
        );

        $this->getNextPage()->shouldReturn(null);
    }

    public function it_gets_previous_page(
        $httpClient,
        $pageFactory,
        ResponseInterface $response,
        StreamInterface $stream,
        Page $previousPage
    ) {
        $previousPageContent = $this->getPageSample();
        $httpClient->sendRequest('GET', 'http://diglin.com/previous', ['Accept' => '*/*'])->willReturn($response);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn(json_encode($previousPageContent));
        $pageFactory->createPage($previousPageContent)->willReturn($previousPage);

        $this->getPreviousPage()->shouldReturn($previousPage);
    }

    public function it_returns_null_when_getting_nonexistent_previous_page($httpClient, $pageFactory)
    {
        $this->beConstructedWith(
            $pageFactory,
            $httpClient,
            'http://diglin.com/first',
            null,
            'http://diglin.com/next',
            10,
            [
                ['identifier' => 'foo'],
                ['identifier' => 'bar'],
            ]
        );

        $this->getPreviousPage()->shouldReturn(null);
    }

    public function it_gets_first_page(
        $httpClient,
        $pageFactory,
        ResponseInterface $response,
        StreamInterface $stream,
        Page $firstPage
    ) {
        $firstPageContent = $this->getPageSample();
        $httpClient->sendRequest('GET', 'http://diglin.com/first', ['Accept' => '*/*'])->willReturn($response);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn(json_encode($firstPageContent));
        $pageFactory->createPage($firstPageContent)->willReturn($firstPage);

        $this->getFirstPage()->shouldReturn($firstPage);
    }

    public function it_gets_items()
    {
        $this->getItems()->shouldReturn([
            ['identifier' => 'foo'],
            ['identifier' => 'bar'],
        ]);
    }

    public function it_gets_count()
    {
        $this->getCount()->shouldReturn(10);
    }

    public function it_has_next_page()
    {
        $this->hasNextPage()->shouldReturn(true);
    }

    public function it_does_not_have_next_page($pageFactory, $httpClient)
    {
        $this->beConstructedWith(
            $pageFactory,
            $httpClient,
            'http://diglin.com/first',
            'http://diglin.com/previous',
            null,
            10,
            [
                ['identifier' => 'foo'],
                ['identifier' => 'bar'],
            ]
        );
        $this->hasNextPage()->shouldReturn(false);
    }

    public function it_does_not_have_previous_page($pageFactory, $httpClient)
    {
        $this->beConstructedWith(
            $pageFactory,
            $httpClient,
            'http://diglin.com/first',
            null,
            'http://diglin.com/next',
            10,
            [
                ['identifier' => 'foo'],
                ['identifier' => 'bar'],
            ]
        );
        $this->hasPreviousPage()->shouldReturn(false);
    }

    public function it_has_previous_page()
    {
        $this->hasPreviousPage()->shouldReturn(true);
    }

    public function it_gets_next_link()
    {
        $this->getNextLink()->shouldReturn('http://diglin.com/next');
    }

    public function it_gets_previous_link()
    {
        $this->getPreviousLink()->shouldReturn('http://diglin.com/previous');
    }

    protected function getPageSample()
    {
        return [
            '_links' => [
                'self' => [
                    'href' => 'http://diglin.com/self',
                ],
                'first' => [
                    'href' => 'http://diglin.com/first',
                ],
                'previous' => [
                    'href' => 'http://diglin.com/previous',
                ],
                'next' => [
                    'href' => 'http://diglin.com/next',
                ],
            ],
            'items_count' => 10,
            '_embedded' => [
                'items' => [
                    ['identifier' => 'foo'],
                    ['identifier' => 'bar'],
                ],
            ],
        ];
    }
}
