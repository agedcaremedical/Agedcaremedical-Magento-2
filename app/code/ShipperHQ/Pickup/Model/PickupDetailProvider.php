<?php
/**
 *
 * ShipperHQ
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
 * @category  ShipperHQ
 * @package   ShipperHQ_Pickup
 * @copyright Copyright (c) 2016 Zowta LLC (http://www.ShipperHQ.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author    ShipperHQ Team sales@shipperhq.com
 */
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ShipperHQ\Pickup\Model;

//use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Checkout\Model\Session;
//use Magento\Store\Model\StoreManagerInterface;

class PickupDetailProvider
{
    /**
     * @var Session
     */
    protected $checkoutSession;
    /**
     * @var \Magento\Directory\Model\RegionFactory
     */
    protected $regionFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Directory\Model\RegionFactory $regionFactory
     */
    public function __construct(
        Session $checkoutSession,
        \Magento\Directory\Model\RegionFactory $regionFactory
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->regionFactory = $regionFactory;
    }

    public function retrieveLocationDetails($locationId, $carrierCode, $carrierGroupId = false)
    {
        $found = false;
        $allDetails = $this->getSavedLocationsForCarrier($carrierCode, $carrierGroupId);
        if ($allDetails && is_array($allDetails)) {
            if(isset($allDetails[$locationId])) {
                $found = $allDetails[$locationId];
            }
        }
        return $found;
    }


    public function getSavedLocationsForCarrier($carrierCode, $carrierGroupId = false)
    {
        $found = false;
        $requestData = $this->checkoutSession->getShipperhqData();
        $allPickupDetails = isset($requestData['pickup_detail']) ? $requestData['pickup_detail'] : array();
        if($carrierGroupId) {
            $found = (isset($allPickupDetails[$carrierGroupId]) && isset($allPickupDetails[$carrierGroupId][$carrierCode])) ?
                $allPickupDetails[$carrierGroupId][$carrierCode] : false;
        }
        else {
            foreach($allPickupDetails as $carrierGroupID => $carrierCodeSet) {
                foreach($carrierCodeSet as $oneCarrierCode => $details) {
                    if ($oneCarrierCode == $carrierCode) {
                        $found = $details;
                    }
                }
            }
        }
        return $found;
    }

    public function setSelectedLocationOnSession($locationId)
    {
        $requestData = $this->checkoutSession->getShipperhqData();
        $requestData['selected_location'] = $locationId;
        $this->checkoutSession->setShipperhqData($requestData);
    }

    public function getSelectedLocationOnSession()
    {
        $requestData = $this->checkoutSession->getShipperhqData();
        return isset($requestData['selected_location']) ? $requestData['selected_location'] : false;
    }

    /**
     * @return string | null
     */
    public function getRegion($countryId, $regionName)
    {
        $regionModel =  $this->regionFactory->create();
        $regionModel->loadByName($regionName, $countryId);
        $id =  $regionModel->getId() ? $regionModel->getId(): null;
        return $id;
    }

}