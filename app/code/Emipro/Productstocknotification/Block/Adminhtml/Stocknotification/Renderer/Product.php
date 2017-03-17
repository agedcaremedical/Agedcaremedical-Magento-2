<?php
namespace Emipro\Productstocknotification\Block\Adminhtml\Stocknotification\Renderer;

class Product extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {

    protected $_catalogProduct;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Catalog\Model\Product $catalogProduct, 
        array $data = []
        ) 
    {
        parent::__construct($context, $data);
        $this->_catalogProduct = $catalogProduct;
        $this->_authorization = $context->getAuthorization();
    }

    public function render(\Magento\Framework\DataObject $row) {
        $p_id = $this->_getValue($row);

        $product = $this->_catalogProduct->load($p_id);
        
        $pro_id = $product->getId();
        $pro_name = $product->getName();
        
        if($p_id != null){
            return '<a href="' . $this->_urlBuilder->getUrl("catalog/product/edit", array("id" => $pro_id)) . '" target="_blank">' . $pro_name . '</a>';
        }
        return;
    }
}