<?php

namespace Agedcareandmedical\Storelocator\Model;

class Items extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Agedcareandmedical\Storelocator\Model\Resource\Items');
    }
}
