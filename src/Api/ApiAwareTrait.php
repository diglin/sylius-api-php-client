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
    /** @var ResourceClientInterface */
    protected $resourceClient;

    /** @var PageFactoryInterface */
    protected $pageFactory;

    /** @var ResourceCursorFactoryInterface */
    protected $cursorFactory;

    /** @var FileSystemInterface */
    protected $fileSystem;

    public function setResourceClient(ResourceClientInterface $resourceClient)
    {
        $this->resourceClient = $resourceClient;
    }

    public function setPageFactory(PageFactoryInterface $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    public function setCursorFactory(ResourceCursorFactoryInterface $cursorFactory)
    {
        $this->cursorFactory = $cursorFactory;
    }

    public function setFileSystem(FileSystemInterface $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }
}
