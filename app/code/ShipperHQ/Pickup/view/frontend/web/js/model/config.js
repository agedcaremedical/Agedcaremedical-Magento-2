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
 * @category ShipperHQ
 * @package ShipperHQ_Pickup
 * @copyright Copyright (c) 2016 Zowta LLC (http://www.ShipperHQ.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author ShipperHQ Team sales@shipperhq.com
 */
define(['ko', 'jquery'],
    function (ko, $) {
        'use strict';
        var show_locations = ko.observable(window.checkoutConfig.shipperhq_pickup.show_locations);
        var loadConfigUrl = window.checkoutConfig.shipperhq_pickup.load_config_url;
        var request_rates_url = window.checkoutConfig.shipperhq_pickup.request_rates_url;
        var locations = ko.observable(window.checkoutConfig.shipperhq_pickup.locations);
        return {
            show_locations: show_locations,
            loadConfigUrl: loadConfigUrl,
            request_rates_url: request_rates_url,
            locations: locations,
            updateConfig: function (config) {
                this.show_locations(config.show_locations);
                this.locations(config.locations);
            },
            reloadConfig: function (callback, carrier) {
                var self = this;
                $.ajax({
                    type: 'GET',
                    url: self.loadConfigUrl,
                    data: {
                        'carrier': carrier
                    },
                    context: $('body')
                }).success(function (data) {
                    if (data.config) {
                        self.updateConfig(data.config.shipperhq_pickup);
                    }
                    callback();
                });
            },
            getLocations: function () {
                var newlocations = this.locations();
                if (newlocations.length == 0) {
                    return [];
                }
                var locations = [];
                for (var id in newlocations) {
                    var place = newlocations[id].locationDetails;
                    if (!place || place == 'null' || place == 'undefined'){
                        continue;
                    }
                    var loc = {
                        key: newlocations[id].locationId,
                        value: place.pickupName + ' (' + place.distance + place.distanceUnit + ')',
                        calendarDetails: newlocations[id].calendarDetails
                    };
                    locations.push(loc);
                }
                return locations;
            },
            getCalendarDetailsForLocation: function(locationId) {
                var locations = this.getLocations();
                var default_ret = false;
                for (var id in locations) {
                    var location = locations[id];
                    if (location.key == locationId) {
                        return this.processCalendarDetails(location.calendarDetails);
                    }
                    if (default_ret == false) {
                        default_ret = this.processCalendarDetails(location.calendarDetails);
                    }
                }
                return default_ret;
            },
            processCalendarDetails: function(data) {
                var calendarData = {
                    show_calendar: data.showDate,
                    dateFormat: data.dateFormat,
                    datepickerFormat: data.datepickerFormat,
                    min_date: data.min_date,
                    max_date: data.max_date,
                    allowed_dates: data.allowed_dates,
                    carrier_code: data.carrier_code,
                    carrier_id: data.carrier_id,
                    timeslots: data.display_time_slots,
                    show_timeslots: data.showTimeslots
                };
                return calendarData;
            }
        };
    });
