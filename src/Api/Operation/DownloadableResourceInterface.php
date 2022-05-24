<?php

namespace Diglin\Sylius\ApiClient\Api\Operation;

use Diglin\Sylius\ApiClient\Exception\HttpException;
use Psr\Http\Message\StreamInterface;

/**
 * API that can download a resource.
 *
 * @author    Laurent Petard <laurent.petard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface DownloadableResourceInterface
{
    /**
     * Downloads a resource by its code.
     *
     * @param string|int $code Code of the resource
     *
     * @throws HttpException
     *
     * @return StreamInterface
     */
    public function download($code): StreamInterface;
}
