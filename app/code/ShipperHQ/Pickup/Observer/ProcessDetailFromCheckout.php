<?php
/**
 *
 * ShipperHQ Shipping Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * Shipper HQ Shipping
 *
 * @category ShipperHQ
 * @package ShipperHQ_Shipping_Carrier
 * @copyright Copyright (c) 2015 Zowta LLC (http://www.ShipperHQ.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author ShipperHQ Team sales@shipperhq.com
 */
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ShipperHQ\Pickup\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * ShipperHQ Shipper module observer
 */
class ProcessDetailFromCheckout implements ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;
    /**
     * @var \ShipperHQ\Shipper\Helper\LogAssist
     */
    private $shipperLogger;
    /**
     * @var \ShipperHQ\Pickup\Model\PickupDetailProvider
     */
    private $pickupDetailProvider;

    protected $valuesMap = array(
        'pickup_location' => 'pickupName',
        'pickup_location_id' => 'pickupId',
        'pickup_latitude' => 'latitude',
        'pickup_longitude' => 'longitude',
        'pickup_email' => 'email',
        'pickup_contact' => 'contactName',
        'pickup_email_option' => 'emailOption'
    );

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \ShipperHQ\Shipper\Helper\LogAssist $shipperLogger
     * @param \ShipperHQ\Pickup\Model\PickupDetailProvider $pickupDetailProvider
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \ShipperHQ\Shipper\Helper\LogAssist $shipperLogger,
        \ShipperHQ\Pickup\Model\PickupDetailProvider $pickupDetailProvider
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->shipperLogger = $shipperLogger;
        $this->pickupDetailProvider = $pickupDetailProvider;
    }

    /**
     * Process calendar fields on checkout
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {

        $addressExtensionAttributes = $observer->getEvent()->getAddressExtnAttributes();
        $additionalDetail = $observer->getAdditionalDetail();
        $carrierCode = $observer->getCarrierCode();

        //TODO - pass this along in observer
        //  $carrierGroupId = $observer->getCarrierGroupId();
        $locationId = false;
        if ($addressExtensionAttributes) {
            $locationId = $addressExtensionAttributes->getLocationId();
            if ($locationId) {
                $details = $this->pickupDetailProvider->getSavedLocationsForCarrier($carrierCode);
                if($details && isset($details[$locationId])) {
                    $fullDetails = $details[$locationId];
                    $additionalDetail = $this->mapSavedDetails($fullDetails, $additionalDetail);
                }
            }
            else {
                $locationId = false;
            }
        }
        if(!$locationId) {
            $additionalDetail = $this->clearDownSavedDetails($additionalDetail);
        }
        $this->pickupDetailProvider->setSelectedLocationOnSession($locationId);
        return $this;
    }

    protected function mapSavedDetails($locationDetails, $additionalDetail)
    {
        foreach ($this->valuesMap as $setting => $retriever)
        {
            if(isset($locationDetails[$retriever])) {
                $additionalDetail->setData($setting, $locationDetails[$retriever]);
            }
        }
        return $additionalDetail;
    }

    protected function clearDownSavedDetails($additionalDetail)
    {
        foreach ($this->valuesMap as $setting => $retriever)
        {
           $additionalDetail->setData($setting, null);

        }
        return $additionalDetail;
    }
}
