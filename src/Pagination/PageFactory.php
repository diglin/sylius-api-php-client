<?php

namespace Diglin\Sylius\ApiClient\Pagination;

use Diglin\Sylius\ApiClient\Client\HttpClientInterface;
use Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface;

/**
 * Factory to create a page object representing a list of resources.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
final class PageFactory implements PageFactoryInterface
{
    /** @var HttpClientInterface */
    private $httpClient;
    /** @var \Diglin\Sylius\ApiClient\Routing\UriGeneratorInterface */
    private $uriGenerator;

    public function __construct(HttpClientInterface $httpClient, UriGeneratorInterface $uriGenerator)
    {
        $this->httpClient = $httpClient;
        $this->uriGenerator = $uriGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function createPage(array $data)
    {
        $data = $this->addFullUri($data);

        $nextLink = $data['_links']['next']['href'] ?? null;
        $previousLink = $data['_links']['previous']['href'] ?? null;
        $firstLink = $data['_links']['first']['href'] ?? null;
        $selftLink = $data['_links']['self']['href'] ?? null;
        $count = $data['total'] ?? null;
        $items = $data['_embedded']['items'] ?? [];

        return new Page(
            new PageFactory($this->httpClient, $this->uriGenerator),
            $this->httpClient,
            $firstLink,
            $previousLink,
            $nextLink,
            $selftLink,
            $count,
            $items
        );
    }

    private function addFullUri(array $data): array
    {
        foreach ($data as $key => $value) {
            if ('_links' === $key && is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    if (is_string($subValue) && 0 === strpos($subValue, '/')) {
                        $value[$subKey]['href'] = $this->uriGenerator->generate(urldecode($subValue));
                    } elseif ($subValue !== null && 0 === strpos(current($subValue), '/')) {
                        $value[$subKey]['href'] = $this->uriGenerator->generate(urldecode(current($subValue)));
                    }
                }
                $data[$key] = $value;
            } elseif (is_array($value)) {
                $data[$key] = $this->addFullUri($value);
            }
        }

        return $data;
    }
}
