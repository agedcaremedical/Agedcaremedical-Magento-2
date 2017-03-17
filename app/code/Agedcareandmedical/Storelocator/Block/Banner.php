<?php
namespace Agedcareandmedical\Storelocator\Block;
use Magento\Framework\View\Element\Template;
use Agedcareandmedical\Storelocator\Model\Items;

class Storelocator extends Template
{
    protected $storelocator;
    
    public function __construct(
          \Magento\Backend\Block\Template\Context $context,
       Items $items,
        array $data = []
    ){
        $this->storelocator = $items;
         parent::__construct($context, $data);

    }
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
    public function getStorelocatorCollection()
    {
        $collection = $this->storelocator->getCollection();
        return $collection;
    }
}
