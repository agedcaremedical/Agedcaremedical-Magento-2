<?php

namespace Emipro\Productstocknotification\Block\Adminhtml;

use Magento\Backend\Block\Widget\Container;

class Stocknotification extends Container {

    protected $_template = 'grid.phtml';

    public function __construct(
    \Magento\Backend\Block\Widget\Context $context, array $data = []
    ) {
        parent::__construct($context, $data);
    }
    protected function _construct()
    {
        $this->_controller = 'prodcutstocknotification';
        $this->_blockGroup = 'Emipro_Productstocknotification';
        parent::_construct();
    }

    protected function _prepareLayout() 
    {
        $this->setChild(
                'grid', $this->getLayout()->createBlock('Emipro\Productstocknotification\Block\Adminhtml\Stocknotification\Grid', 'customoption.view.grid')
        );
        return parent::_prepareLayout();
    }

    protected function _getCreateUrl() 
    {
        return $this->getUrl('productstocknotification/*/new');
    }

    protected function getGridUrl() 
    {
        return $this->getUrl('productstocknotification/*/new');
    }

    public function getGridHtml() {
        return $this->getChildHtml('grid');
    }
}
