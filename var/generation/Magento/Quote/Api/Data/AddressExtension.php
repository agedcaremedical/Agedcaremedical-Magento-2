<?php
namespace Magento\Quote\Api\Data;

/**
 * Extension class for @see \Magento\Quote\Api\Data\AddressInterface
 */
class AddressExtension extends \Magento\Framework\Api\AbstractSimpleObject implements \Magento\Quote\Api\Data\AddressExtensionInterface
{
    /**
     * @return string|null
     */
    public function getDeliveryDate()
    {
        return $this->_get('delivery_date');
    }

    /**
     * @param string $deliveryDate
     * @return $this
     */
    public function setDeliveryDate($deliveryDate)
    {
        $this->setData('delivery_date', $deliveryDate);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimeSlot()
    {
        return $this->_get('time_slot');
    }

    /**
     * @param string $timeSlot
     * @return $this
     */
    public function setTimeSlot($timeSlot)
    {
        $this->setData('time_slot', $timeSlot);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocationId()
    {
        return $this->_get('location_id');
    }

    /**
     * @param string $locationId
     * @return $this
     */
    public function setLocationId($locationId)
    {
        $this->setData('location_id', $locationId);
        return $this;
    }
}
