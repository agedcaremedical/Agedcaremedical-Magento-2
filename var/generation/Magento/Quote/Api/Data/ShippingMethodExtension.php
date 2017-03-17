<?php
namespace Magento\Quote\Api\Data;

/**
 * Extension class for @see \Magento\Quote\Api\Data\ShippingMethodInterface
 */
class ShippingMethodExtension extends \Magento\Framework\Api\AbstractSimpleObject implements \Magento\Quote\Api\Data\ShippingMethodExtensionInterface
{
    /**
     * @return string|null
     */
    public function getTooltip()
    {
        return $this->_get('tooltip');
    }

    /**
     * @param string $tooltip
     * @return $this
     */
    public function setTooltip($tooltip)
    {
        $this->setData('tooltip', $tooltip);
        return $this;
    }
}
