<?php
namespace Greenlab\Sidebar\Model;

use \Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;
use \Magento\Store\Model\StoreManagerInterface;

/**
* Class ConfigProvider
* @codeCoverageIgnore
*/
final class CmsConfigProvider implements ConfigProviderInterface
{

private $layout;
private $storeManager;
private $cmsBlock;

public function __construct(LayoutInterface $layout, StoreManagerInterface $storeManager, $blockId)
{
$this->layout = $layout;
$this->storeManager = $storeManager;
$this->cmsBlock = $blockId;
}

public function getStoreId()
{
return $this->storeManager->getStore()->getId();
}

public function constructBlock($blockId)
{
$storeId = $this->getStoreId();
$block = $this->layout->createBlock('Magento\Cms\Block\Block')
->setBlockId($blockId)->setStoreId($storeId)->toHtml();
return $block;
}

public function getConfig()
{
$cmsBlock = '';
$blockId = $this->cmsBlock;
if (isset($blockId) && $blockId != '') {
$cmsBlock = $this->constructBlock($blockId);
}
return ['cms_block' => $cmsBlock];
}
}