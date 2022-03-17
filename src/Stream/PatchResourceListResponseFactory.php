<?php

namespace Diglin\Sylius\ApiClient\Stream;

use Psr\Http\Message\StreamInterface;

/**
 * Factory to create an PatchResourceListResponseFactory object.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class PatchResourceListResponseFactory
{
    public function create(StreamInterface $bodyStream)
    {
        return new PatchResourceListResponse($bodyStream, new LineStreamReader());
    }
}
