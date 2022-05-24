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

trait ApiAwareTrait
{
    private ResourceClientInterface $resourceClient;
    private PageFactoryInterface $pageFactory;
    private ResourceCursorFactoryInterface $cursorFactory;
    private FileSystemInterface $fileSystem;

    public function setResourceClient(ResourceClientInterface $resourceClient): void
    {
        $this->resourceClient = $resourceClient;
    }

    public function setPageFactory(PageFactoryInterface $pageFactory): void
    {
        $this->pageFactory = $pageFactory;
    }

    public function setCursorFactory(ResourceCursorFactoryInterface $cursorFactory): void
    {
        $this->cursorFactory = $cursorFactory;
    }

    public function setFileSystem(FileSystemInterface $fileSystem): void
    {
        $this->fileSystem = $fileSystem;
    }
}
