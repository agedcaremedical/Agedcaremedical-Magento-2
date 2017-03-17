<?php

namespace Agedcareandmedical\Storelocator\Model\Resource\Items;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Agedcareandmedical\Storelocator\Model\Items', 'Agedcareandmedical\Storelocator\Model\Resource\Items');
    }
}
