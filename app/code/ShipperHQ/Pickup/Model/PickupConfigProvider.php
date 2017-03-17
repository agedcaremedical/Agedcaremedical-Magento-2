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

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Checkout\Model\Session;
use Magento\Store\Model\StoreManagerInterface;

class PickupConfigProvider implements ConfigProviderInterface
{
    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Session               $checkoutSession
     */
    public function __construct(StoreManagerInterface $storeManager, Session $checkoutSession)
    {
        $this->_storeManager = $storeManager;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        $carrier = null;
        $quote = $this->checkoutSession->getQuote();
        $method = $quote->getShippingAddress()->getShippingMethod();
        if (isset($method) && strpos($method, '_') > 0) {
            $method = explode('_', $method);
            $carrier = $method[0];
        }
        return $this->getPickupConfig($carrier);
    }

    /**
     * Get the location config data based on selected shipping carrier
     *
     * @param $carrier
     * @return mixed
     */
    public function getPickupConfig($carrier = 'default')
    {

        $locationConfig['default'] = [
            'load_config_url'   => $this->getLoadConfigUrl(),
            'request_rates_url' => $this->getRequestRatesUrl(),
            'populate_location_address_url' => $this->getPopulateLocationAddressUrl(),
            'locations'         => [],
            'show_locations'    => false
        ];
        $requestData = $this->checkoutSession->getShipperhqData();
        $allPickupDetails = isset($requestData['pickup_detail']) ? $requestData['pickup_detail'] : null;

        //To handle multiple calendar instances we can pass config such as this - need to reference carrier group ID when we do split
        if (is_array($allPickupDetails)) {
            foreach ($allPickupDetails as $carrierGroupId => $carrierGroupCalDetails) {
                foreach ($carrierGroupCalDetails as $carrierCode => $carrierPickupDetails) {
                    $pickupLocations = [];
                    foreach ($carrierPickupDetails as $locationId => $location) {
                        $pickupLocations[] = [
                            'locationId'        => $locationId,
                            'locationDetails'   => [
                                'pickupName'    => $location['pickupName'],
                                'latitude'      => $location['latitude'],
                                'longitude'     => $location['longitude'],
                                'street1'       => $location['street1'],
                                'street2'       => $location['street2'],
                                'city'          => $location['city'],
                                'state'         => $location['state'],
                                'country'       => $location['country'],
                                'zipcode'       => $location['zipcode'],
                                'phone'         => $location['phone'],
                                'distance'      => $location['distance'],
                                'distanceUnit'  => $location['distanceUnit'],
                                'openingHours'  => $location['openingHours'],
                                'closingHours'  => $location['closingHours'],
                                'standardHours' => $location['standardHours'],
                            ],
                            'calendarDetails'   => $location['calendarDetails'],
                            'load_config_url'   => $this->getLoadConfigUrl(),
                            'request_rates_url' => $this->getRequestRatesUrl(),
                            'carrier_code'      => $carrierCode,
                            'carrier_id'        => $location['carrier_id'],
                            'carrier_group_id'  => $carrierGroupId
                        ];
                    }
                    $carrierPickupConfig['show_locations'] = (count($pickupLocations) > 0);
                    $carrierPickupConfig['locations'] = $pickupLocations;
                    $locationConfig[$carrierCode] = $carrierPickupConfig;
                }
            }
        }
        if (!isset($locationConfig[$carrier])) {
            $carrier = 'default';
        }
        $config['shipperhq_pickup'] = $locationConfig[$carrier];
        return $config;
    }

    /**
     * Returns URL to controller action to refresh and load latest calendar configuration
     *
     * @return string
     */
    protected function getLoadConfigUrl()
    {
        $store = $this->_storeManager->getStore();
        return $store->getUrl('shipperhq_pickup/checkout/loadConfig', ['_secure' => $store->isCurrentlySecure()]);
    }

    /**
     * Returns URL to controller action to request shipping rates for selected date
     *
     * @return string
     */
    protected function getRequestRatesUrl()
    {
        $store = $this->_storeManager->getStore();
        return $store->getUrl('shipperhq_pickup/checkout/requestRates', ['_secure' => $store->isCurrentlySecure()]);
    }

    /**
     * Returns URL to controller action to refresh and load latest calendar configuration
     *
     * @return string
     */
    protected function getPopulateLocationAddressUrl()
    {
        $store = $this->_storeManager->getStore();
        return $store->getUrl('shipperhq_pickup/checkout/populateLocationAddress', ['_secure' => $store->isCurrentlySecure()]);
    }
}