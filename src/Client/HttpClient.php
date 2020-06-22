<?php

namespace Diglin\Sylius\ApiClient\Client;

use Http\Client\HttpClient as Client;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Http client to send a request without any authentication.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class HttpClient implements HttpClientInterface
{
    /** @var Client */
    protected $httpClient;
    /** @var RequestFactory */
    protected $requestFactory;
    /** @var HttpExceptionHandler */
    protected $httpExceptionHandler;
    /** @var StreamFactoryInterface */
    protected $streamFactory;
    /** @var array */
    private $defaultHeaders;

    public function __construct(
        Client $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        $defaultHeaders = []
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->httpExceptionHandler = new HttpExceptionHandler();
        $this->streamFactory = $streamFactory;
        $this->defaultHeaders = $defaultHeaders;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest($httpMethod, $uri, array $headers = [], $body = null): ResponseInterface
    {
        $request = $this->requestFactory->createRequest($httpMethod, $uri);

        if (null !== $body) {
            $request = $request->withBody($this->streamFactory->createStream($body));
        }

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            $request = $request->withAddedHeader($name, $value);
        }

        $response = $this->httpClient->sendRequest($request);

        return $this->httpExceptionHandler->transformResponseToException($request, $response);
    }
}
