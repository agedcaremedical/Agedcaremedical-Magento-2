<?php
/**
 * Copyright © 2015 Webskitters. All rights reserved.
 */

namespace Agedcare\Brochure\Model\Resource;

class Items extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('agedcare_brochure_items', 'id');
    }
}
