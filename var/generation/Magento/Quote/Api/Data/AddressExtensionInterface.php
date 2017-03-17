<?php
namespace Magento\Quote\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Quote\Api\Data\AddressInterface
 */
interface AddressExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getDeliveryDate();

    /**
     * @param string $deliveryDate
     * @return $this
     */
    public function setDeliveryDate($deliveryDate);

    /**
     * @return string|null
     */
    public function getTimeSlot();

    /**
     * @param string $timeSlot
     * @return $this
     */
    public function setTimeSlot($timeSlot);

    /**
     * @return string|null
     */
    public function getLocationId();

    /**
     * @param string $locationId
     * @return $this
     */
    public function setLocationId($locationId);
}
