<?php

namespace Emipro\Productstocknotification\Block\Product;

use Magento\Catalog\Block\Product\AbstractProduct;

class View extends AbstractProduct
{
	public function getPostformUrl($url) {
        return $this->_urlBuilder->getUrl($url);
    }
    
    public function getParamId($param) {
        return $this->getRequest()->getParam($param);
    }

    public function getStockItem($productId) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $stockItem = $objectManager->get('\Magento\CatalogInventory\Model\Stock\StockItemRepository')->get($productId);
        return $stockItem->getIsInStock();
    }

    public function getCustomerEmail() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customer = $objectManager->create('Magento\Customer\Model\Session');
        if($customer->isLoggedIn())
        {
            return $customer->getCustomer()->getEmail();
        }
    }
}
