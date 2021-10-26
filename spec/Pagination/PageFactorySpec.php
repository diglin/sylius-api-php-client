<?php

namespace spec\Diglin\Sylius\ApiClient\Pagination;

use Diglin\Sylius\ApiClient\Client\HttpClientInterface;
use Diglin\Sylius\ApiClient\Pagination\Page;
use Diglin\Sylius\ApiClient\Pagination\PageFactory;
use Diglin\Sylius\ApiClient\Pagination\PageFactoryInterface;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;
use PhpSpec\ObjectBehavior;

class PageFactorySpec extends ObjectBehavior
{
    public function let(HttpClientInterface $httpClient, UriGeneratorInterface $uriGenerator)
    {
        $this->beConstructedWith($httpClient, $uriGenerator);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PageFactory::class);
        $this->shouldImplement(PageFactoryInterface::class);
    }

    public function it_creates_a_page_with_all_links($httpClient, $uriGenerator)
    {
        $data = [
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
            'total' => 10,
            '_embedded' => [
                'items' => [
                    ['identifier' => 'foo'],
                    ['identifier' => 'bar'],
                ],
            ],
        ];

        $this->createPage($data)->shouldReturnAnInstanceOf(Page::class);
        $this->createPage($data)->shouldBeLike(
            new Page(
                new PageFactory($httpClient->getWrappedObject(), $uriGenerator->getWrappedObject()),
                $httpClient->getWrappedObject(),
                'http://diglin.com/first',
                'http://diglin.com/previous',
                'http://diglin.com/next',
                10,
                [
                    ['identifier' => 'foo'],
                    ['identifier' => 'bar'],
                ]
            )
        );
    }

    public function it_creates_a_page_without_next_and_previous_links($httpClient, $uriGenerator)
    {
        $data = [
            '_links' => [
                'self' => [
                    'href' => 'http://diglin.com/self',
                ],
                'first' => [
                    'href' => 'http://diglin.com/first',
                ],
            ],
            'total' => 10,
            '_embedded' => [
                'items' => [
                    ['identifier' => 'foo'],
                    ['identifier' => 'bar'],
                ],
            ],
        ];

        $this->createPage($data)->shouldReturnAnInstanceOf(Page::class);
        $this->createPage($data)->shouldBeLike(
            new Page(
                new PageFactory($httpClient->getWrappedObject(), $uriGenerator->getWrappedObject()),
                $httpClient->getWrappedObject(),
                'http://diglin.com/first',
                null,
                null,
                10,
                [
                    ['identifier' => 'foo'],
                    ['identifier' => 'bar'],
                ]
            )
        );
    }

    public function it_creates_a_page_without_count($httpClient, $uriGenerator)
    {
        $data = [
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
            '_embedded' => [
                'items' => [
                    ['identifier' => 'foo'],
                    ['identifier' => 'bar'],
                ],
            ],
        ];

        $this->createPage($data)->shouldReturnAnInstanceOf(Page::class);
        $this->createPage($data)->shouldBeLike(
            new Page(
                new PageFactory($httpClient->getWrappedObject(), $uriGenerator->getWrappedObject()),
                $httpClient->getWrappedObject(),
                'http://diglin.com/first',
                'http://diglin.com/previous',
                'http://diglin.com/next',
                null,
                [
                    ['identifier' => 'foo'],
                    ['identifier' => 'bar'],
                ]
            )
        );
    }
}
