<?php

namespace Diglin\Sylius\ApiClient\Pagination;

use Diglin\Sylius\ApiClient\Client\HttpClientInterface;

/**
 * Page represents a list of paginated resources.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Page implements PageInterface
{
    /** @var PageFactoryInterface */
    protected $pageFactory;

    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var string */
    protected $firstLink;

    /** @var string */
    protected $previousLink;

    /** @var string */
    protected $nextLink;

    /** @var string|null */
    protected $selfLink;

    /** @var int */
    protected $count;

    /** @var array */
    protected         $items;

    /**
     * @param string      $firstLink
     * @param null|string $previousLink
     * @param null|string $nextLink
     * @param null|string $selfLink
     * @param null|int    $count
     */
    public function __construct(PageFactoryInterface $pageFactory, HttpClientInterface $httpClient, $firstLink, $previousLink, $nextLink, $selfLink, $count, array $items)
    {
        $this->pageFactory = $pageFactory;
        $this->httpClient = $httpClient;
        $this->firstLink = $firstLink;
        $this->previousLink = $previousLink;
        $this->nextLink = $nextLink;
        $this->selfLink = $selfLink;
        $this->count = $count;
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstPage()
    {
        return $this->getPage($this->firstLink);
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousPage()
    {
        return $this->hasPreviousPage() ? $this->getPage($this->previousLink) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextPage()
    {
        return $this->hasNextPage() ? $this->getPage($this->nextLink) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNextPage()
    {
        return null !== $this->nextLink && $this->selfLink != $this->nextLink;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPreviousPage()
    {
        return null !== $this->previousLink;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextLink()
    {
        return $this->nextLink;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousLink()
    {
        return $this->previousLink;
    }

    /**
     * Returns the page given a complete uri.
     *
     * @param string $uri
     *
     * @return PageInterface
     */
    protected function getPage($uri)
    {
        $response = $this->httpClient->sendRequest('GET', $uri, ['Accept' => '*/*']);
        $data = json_decode($response->getBody()->getContents(), true);

        return $this->pageFactory->createPage($data);
    }
}
