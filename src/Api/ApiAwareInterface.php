<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 *
 * @category    SyliusApiClient
 *
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */

namespace Diglin\Sylius\ApiClient\Api;

use Diglin\Sylius\ApiClient\Client\ResourceClientInterface;
use Diglin\Sylius\ApiClient\FileSystem\FileSystemInterface;
use Diglin\Sylius\ApiClient\Pagination\PageFactoryInterface;
use Diglin\Sylius\ApiClient\Pagination\ResourceCursorFactoryInterface;

interface ApiAwareInterface
{
    public function setResourceClient(ResourceClientInterface $resourceClient): void;

    public function setPageFactory(PageFactoryInterface $pageFactory): void;

    public function setCursorFactory(ResourceCursorFactoryInterface $cursorFactory): void;

    public function setFileSystem(FileSystemInterface $fileSystem): void;
}
