<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Feed
 */

namespace Amasty\Feed\Model\ResourceModel\Feed\Grid;

class ExecuteModeList implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return array(
            'manual' => __('Manual'),
            'hourly' => __('Hourly'),
            'daily' => __('Daily'),
            'weekly' => __('Weekly'),
            'monthly' => __('Monthly'),
        );
    }
}
