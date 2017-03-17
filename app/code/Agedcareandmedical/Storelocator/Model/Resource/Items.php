<?php
/**
 * Copyright © 2015 Webskitters. All rights reserved.
 */

namespace Agedcareandmedical\Storelocator\Model\Resource;

class Items extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('agedcareandmedical_storelocator_items', 'id');
    }
}
