<?php
namespace Emipro\Productstocknotification\Block\Adminhtml\Stocknotification;
 
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{   
    protected $moduleManager;

    protected $_stocknotification;

    protected $_catalogProduct;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Emipro\Productstocknotification\Model\StocknotificationFactory $stocknotification,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Catalog\Model\Product $catalogProduct,
        array $data = []
    ) {
        $this->_stocknotification = $stocknotification;
        $this->moduleManager = $moduleManager;
        $this->_catalogProduct = $catalogProduct;
        parent::__construct($context, $backendHelper, $data);
    }
    
    protected function _construct() {
        parent::_construct();
        $this->setId('productstocknotificationGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('grid_record');
    }
 
    protected function _prepareCollection() {
        $collection = $this->_stocknotification->create()->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns() {        
        $this->addColumn(
            'id', 
            [
                'header' => __('ID'),
                'align' => 'right',
                'width' => '10px',
                'type' => 'number',
                'index' => 'id',
            ]
        );

        $this->addColumn(
                'product_id', [
            'header' => __('Product Name'),
            'index' => 'product_id',
            'type' => 'text',
            'renderer' => '\Emipro\Productstocknotification\Block\Adminhtml\Stocknotification\Renderer\Product',
            'filter_condition_callback' => array($this, '_filterHasUrlCallback'),
                ]
        );

        $this->addColumn('email_id', 
            [
                'header' => __('Email Id'),
                'align' => 'left',
                'width' => '150px',
                'type' => 'text',
                'index' => 'email_id',
            ]
        );

        $this->addColumn('created_at', 
            [
                'header' => __('Subcribed At'),
                'align' => 'left',
                'width' => '150px',
                'type' => 'datetime',
                'index' => 'created_at',
            ]
        );
        
        $block = $this->getLayout()->getBlock('productstocknotification.bottom.links');
        if ($block) {
            $this->setChild('productstocknotification.bottom.links', $block);
        }
        return parent::_prepareColumns();
    }

    protected function _filterHasUrlCallback($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $pro = $this->_catalogProduct->getCollection();
        $pro->addFieldToFilter('name', array('like' => '%' . $value . '%'));
        $ids = array();
        foreach ($pro as $item) {
            $ids[] = $item->getId();
        }
        $this->getCollection()->addFieldToFilter('product_id', array('in' => $ids));
        return $this;
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');
 
        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $this->getMassactionBlock()->addItem(
            'send_delete',
            [
                'label' => __('Send & Delete'),
                'url' => $this->getUrl('*/*/sendDelete')
            ]
        );
 
        return $this;
    }

    public function getGridUrl() {
        return $this->getUrl('productstocknotification/*/grid', ['_current' => true]);
    }
}