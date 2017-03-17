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
 * @package   ShipperHQ_Calendar
 * @copyright Copyright (c) 2015 Zowta LLC (http://www.ShipperHQ.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author    ShipperHQ Team sales@shipperhq.com
 */
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ShipperHQ\Calendar\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;

class CalendarConfigProvider implements ConfigProviderInterface
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;
    /**
     * @var DateTime
     */
    protected $coreDate;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Checkout\Model\Session            $checkoutSession
     * @param DateTime                                   $coreDate
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Checkout\Model\Session $checkoutSession,
        DateTime $coreDate
    )
    {
        $this->_storeManager = $storeManager;
        $this->checkoutSession = $checkoutSession;
        $this->coreDate = $coreDate;
    }

    /**
     * {@inheritdoc}
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
        return $this->getCalendarConfig($carrier);
    }

    /**
     * Get the calendar config data based on selected shipping carrier
     *
     * @param $carrier
     * @return mixed
     */
    public function getCalendarConfig($carrier = 'default')
    {
        $calendarConfig['default'] = [
            'dateFormat'        => 'Y-m-d',
            'datepickerFormat'  => 'Y-m-d',
            'min_date'          => $this->coreDate->date('Y-m-d'),
            'max_date'          => $this->coreDate->date('Y-m-d', '+1 Year'),
            'date_selected'     => $this->coreDate->date('Y-m-d'),
            'load_config_url'   => $this->getLoadConfigUrl(),
            'request_rates_url' => $this->getRequestRatesUrl(), //SHQ16-1770 deprecated
            'allowed_dates'     => [],
            'timeslots'         => [],
            'show_calendar'     => false,
            'show_timeslots'    => false
        ];
        $requestData = $this->checkoutSession->getShipperhqData();
        $allCalendarDetails = isset($requestData['calendar_detail']) ? $requestData['calendar_detail'] : null;

        //To handle multiple calendar instances we can pass config such as this - need to reference carrier group ID when we do split
        if (is_array($allCalendarDetails)) {
            foreach ($allCalendarDetails as $carrierGroupId => $carrierGroupCalDetails) {
                foreach ($carrierGroupCalDetails as $carrierCode => $carrierCalendarDetails) {
                    $carrierCalendarConfig = [
                        'load_config_url'   => $this->getLoadConfigUrl(),
                        'request_rates_url' => $this->getRequestRatesUrl(),
                        'dateFormat'        => $carrierCalendarDetails['dateFormat'],
                        'datepickerFormat'  => $carrierCalendarDetails['datepickerFormat'],
                        'min_date'          => $carrierCalendarDetails['min_date'],
                        'max_date'          => $carrierCalendarDetails['max_date'],
                        'allowed_dates'     => $carrierCalendarDetails['allowed_dates'],
                        'date_selected'     => $carrierCalendarDetails['default_date'],
                        'carrier_code'      => $carrierCode,
                        'carrier_id'        => $carrierCalendarDetails['carrier_id'],
                        'carrier_group_id'  => $carrierGroupId,
                        'timeslots'         => $carrierCalendarDetails['display_time_slots'],
                        'show_timeslots'    => $carrierCalendarDetails['showTimeslots']
                    ];
                    $calendarConfig['default']['dateFormat'] = $carrierCalendarDetails['dateFormat'];
                    $calendarConfig['default']['datepickerFormat'] = $carrierCalendarDetails['datepickerFormat'];
                    $calendarConfig['default']['min_date'] = $carrierCalendarDetails['min_date'];
                    $calendarConfig['default']['max_date'] = $carrierCalendarDetails['max_date'];
                    $calendarConfig['default']['date_selected'] = $carrierCalendarDetails['default_date'];
                    $carrierCalendarConfig['show_calendar'] = true;
                    $calendarConfig[$carrierCode] = $carrierCalendarConfig;
                }
            }
        }
        if (!isset($calendarConfig[$carrier])) {
            $carrier = 'default';
        }
        $config['shipperhq_calendar'] = $calendarConfig[$carrier];
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
        return $store->getUrl('shipperhq_calendar/checkout/loadConfig', ['_secure' => $store->isCurrentlySecure()]);
    }

    /**
     * Returns URL to controller action to request shipping rates for selected date
     *
     * @return string
     * @deprecated
     */
    protected function getRequestRatesUrl()
    {
        $store = $this->_storeManager->getStore();
        return $store->getUrl('shipperhq_calendar/checkout/requestRates', ['_secure' => $store->isCurrentlySecure()]);
    }

}
