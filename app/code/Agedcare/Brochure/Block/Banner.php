<?php
namespace Agedcare\Brochure\Block;
use Magento\Framework\View\Element\Template;
use Agedcare\Brochure\Model\Items;

class Brochure extends Template
{
    protected $brochure;
    
    public function __construct(
          \Magento\Backend\Block\Template\Context $context,
       Items $items,
        array $data = []
    ){
        $this->brochure = $items;
         parent::__construct($context, $data);

    }
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
    public function getBrochureCollection()
    {
        $collection = $this->brochure->getCollection();
        return $collection;
    }
}
