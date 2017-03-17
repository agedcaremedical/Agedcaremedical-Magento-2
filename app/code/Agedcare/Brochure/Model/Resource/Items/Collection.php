<?php

namespace Agedcare\Brochure\Model\Resource\Items;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Agedcare\Brochure\Model\Items', 'Agedcare\Brochure\Model\Resource\Items');
    }
}
