<?php
namespace Magento\Quote\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Quote\Api\Data\ShippingMethodInterface
 */
interface ShippingMethodExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getTooltip();

    /**
     * @param string $tooltip
     * @return $this
     */
    public function setTooltip($tooltip);
}
