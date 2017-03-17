<?php
namespace Emipro\Productstocknotification\Observer;
use Magento\Framework\Event\ObserverInterface;

class Saveproduct implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {  
    	$product = $observer->getProduct();
        $productId = $product->getId();
        $isInStockNotify = $product->getStockData('is_in_stock');
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		if($isInStockNotify == '1')
		{
			return $objectManager->create('Emipro\Productstocknotification\Helper\Data')->getProductId($productId);
		}
    }   
}
