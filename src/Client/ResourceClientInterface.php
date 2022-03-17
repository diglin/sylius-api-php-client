<?php

namespace Diglin\Sylius\ApiClient\Client;

use Diglin\Sylius\ApiClient\Exception\HttpException;
use Diglin\Sylius\ApiClient\Exception\InvalidArgumentException;
use Diglin\Sylius\ApiClient\Filter\FilterBuilderInterface;
use Diglin\Sylius\ApiClient\Sort\SortBuilderInterface;
use Diglin\Sylius\ApiClient\Stream\PatchResourceListResponse;
use Diglin\Sylius\ApiClient\Stream\UpsertResourceListResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Generic client interface to execute common request on resources.
 *
 * @author    Laurent Petard <laurent.petard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface ResourceClientInterface
{
    /**
     * Gets a resource.
     *
     * @param string|\Stringable $uri             URI of the resource
     * @param array              $uriParameters   URI parameters of the resource
     * @param array              $queryParameters Query parameters of the request
     *
     * @throws HttpException if the request failed
     *
     * @return array
     */
    public function getResource(string|\Stringable $uri, array $uriParameters = [], array $queryParameters = []): array;

    /**
     * Gets a list of resources.
     *
     * @param string|\Stringable $uri             URI of the resource
     * @param array              $uriParameters   URI parameters of the resource
     * @param int                $limit           The maximum number of resources to return.
     *                                            Do note that the server has a default value if you don't specify anything.
     *                                            The server has a maximum limit allowed as well.
     * @param array              $queryParameters Additional query parameters of the request
     *
     * @return list<array>
     */
    public function getResources(string|\Stringable $uri, array $uriParameters = [], $limit = 10, array $queryParameters = [], FilterBuilderInterface $filterBuilder = null, SortBuilderInterface $sortBuilder = null): iterable;

    /**
     * Creates a resource.
     *
     * @param string|\Stringable $uri           URI of the resource
     * @param array              $uriParameters URI parameters of the resource
     * @param array              $body          Body of the request
     *
     * @throws HttpException if the request failed
     *
     * @return int status code 201 indicating that the resource has been well created
     */
    public function createResource(string|\Stringable $uri, array $uriParameters = [], array $body = []): int;

    /**
     * Creates a resource using a multipart request.
     *
     * @param string|\Stringable $uri URI of the resource
     * @param array  $uriParameters   URI parameters of the resources
     * @param array  $requestParts    Parts of the request. Each part is defined with "name", "contents", and "options"
     *
     * @throws InvalidArgumentException if a given request part is invalid
     * @throws HttpException            if the request failed
     *
     * @return ResponseInterface the response of the creation request
     */
    public function createMultipartResource(string|\Stringable $uri, array $uriParameters = [], array $requestParts = []): ResponseInterface;

    /**
     * Creates a resource if it does not exist yet, otherwise updates partially the resource.
     *
     * @param string|\Stringable $uri URI of the resource
     * @param array  $uriParameters   URI parameters of the resource
     * @param array  $body            Body of the request
     *
     * @throws HttpException if the request failed
     *
     * @return int Status code 201 indicating that the resource has been well created.
     *             Status code 204 indicating that the resource has been well updated.
     */
    public function upsertResource(string|\Stringable $uri, array $uriParameters = [], array $body = []): int;

    /**
     * Updates or creates several resources.
     *
     * @param string|\Stringable    $uri           URI of the resource
     * @param array                 $uriParameters URI parameters of the resource
     * @param array|StreamInterface $resources     array of resources to create or update.
     *                                             You can pass your own StreamInterface implementation as well.
     *
     * @throws HttpException            if the request failed
     * @throws InvalidArgumentException if the resources or any part thereof are invalid
     *
     * @return UpsertResourceListResponse returns an iterable object, each entry corresponding to the response of the upserted resource
     */
    public function upsertResourceList(string|\Stringable $uri, array $uriParameters = [], array|StreamInterface $resources = []): UpsertResourceListResponse;

    /**
     * Updates partially the resource.
     *
     * @param string|\Stringable $uri URI of the resource
     * @param array  $uriParameters   URI parameters of the resource
     * @param array  $body            Body of the request
     *
     * @throws HttpException if the request failed
     *
     * @return int Status code 201 indicating that the resource has been well created.
     *             Status code 204 indicating that the resource has been well updated.
     */
    public function patchResource(string|\Stringable $uri, array $uriParameters = [], array $body = []): int;

    /**
     * Updates partially several resources.
     *
     * @param string|\Stringable    $uri           URI of the resource
     * @param array                 $uriParameters URI parameters of the resource
     * @param array|StreamInterface $resources     array of resources to create or update.
     *                                             You can pass your own StreamInterface implementation as well.
     *
     * @throws HttpException            if the request failed
     * @throws InvalidArgumentException if the resources or any part thereof are invalid
     *
     * @return PatchResourceListResponse returns an iterable object, each entry corresponding to the response of the upserted resource
     */
    public function patchResourceList(string|\Stringable $uri, array $uriParameters = [], array|StreamInterface $resources = []): PatchResourceListResponse;

    /**
     * Updates partially the resource.
     *
     * @param string|\Stringable $uri URI of the resource
     * @param array  $uriParameters   URI parameters of the resource
     * @param array  $body            Body of the request
     *
     * @throws HttpException if the request failed
     *
     * @return int Status code 201 indicating that the resource has been well created.
     *             Status code 204 indicating that the resource has been well updated.
     */
    public function putResource(string|\Stringable $uri, array $uriParameters = [], array $body = []): int;

    /**
     * Deletes a resource.
     *
     * @param string|\Stringable $uri URI of the resource to delete
     * @param array  $uriParameters   URI parameters of the resource
     *
     * @throws HttpException If the request failed
     *
     * @return int Status code 204 indicating that the resource has been well deleted
     */
    public function deleteResource(string|\Stringable $uri, array $uriParameters = []): int;

    /**
     * Gets a streamed resource.
     *
     * @param string|\Stringable $uri URI of the resource
     * @param array  $uriParameters   URI parameters of the resource
     *
     * @throws HttpException If the request failed
     *
     * @return StreamInterface
     */
    public function getStreamedResource(string|\Stringable $uri, array $uriParameters = []): StreamInterface;
}
