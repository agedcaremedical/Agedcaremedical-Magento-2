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
 * @package ShipperHQ_Calendar
 * @copyright Copyright (c) 2015 Zowta LLC (http://www.ShipperHQ.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author ShipperHQ Team sales@shipperhq.com
 */
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    "underscore",
    'ko',
    'uiComponent',
    'ShipperHQ_Pickup/js/model/config',
    'ShipperHQ_Calendar/js/model/config',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-service',
    'Magento_Checkout/js/model/resource-url-manager',
    'mage/storage'
], function ($, _, ko, Component, pickupConfig, calendarConfig, quote, shippingService, resourceUrlManager, storage) {
    'use strict';

    var myLocation = ko.observable(null);
    var shouldShow = ko.computed(function() { return pickupConfig.show_locations(); });
    var locations = ko.observableArray(pickupConfig.getLocations());
    var shipping_method = null;

    return Component.extend({
        defaults: {
            template: 'ShipperHQ_Pickup/checkout/shipping/shipperhq-pickup'
        },
        myLocation: myLocation,
        shouldShow: shouldShow,
        locations: locations,
        shipping_method: shipping_method,
        hideLocations: function () {
            this.locations([]);
            pickupConfig.show_locations(false);
        },
        initialize: function () {
            this._super();

            var self = this;
            var refreshLocations = function () {
                self.locations(pickupConfig.getLocations());
                updateLocation($('#shipperhq_location').val());
            };

            quote.shippingMethod.subscribe(function (newValue) {
                if ((newValue === true) || (newValue == null) || (quote.shippingMethod() == null)) {
                    // no shipping method set yet, hide calendar
                    self.hideLocations();
                    return; // and stop here
                }
                var method = newValue.carrier_code + '_' + newValue.method_code;
                if (method == this.shipping_method) {
                    return;
                }
                this.shipping_method = method;
                // Shipping method set, reload calendar details
                pickupConfig.reloadConfig(refreshLocations, newValue.carrier_code);
            }, this);

            shippingService.isLoading.subscribe(function (status) {
                if (calendarConfig.processing) {
                    return; // Don't do anything since we triggered the update
                }
                if (status == false) { // done loading rates
                    if (quote.shippingMethod() == null) {
                        // no shipping method set yet
                        self.hideLocations();
                        return; // stop here
                    }
                    pickupConfig.reloadConfig(refreshLocations, quote.shippingMethod().carrier_code);
                }
            });

            var updateLocation = function(value) {
                if (value == null || value == "") {
                    return;
                }
                var calendarDetails = pickupConfig.getCalendarDetailsForLocation(value);
                if (calendarDetails == false) { // Must have been an invalid location
                    return;
                }
                calendarConfig.updateConfig(calendarDetails);
                calendarConfig.date_selected(calendarConfig.min_date);
            };

            ko.bindingHandlers.shq_pickup = {
                init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
                    ko.utils.registerEventHandler(element, "change", function () {
                        updateLocation($(element).val());
                    });

                    // Manually call this on initial load
                    updateLocation($(element).val());
                },
                update: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                    updateLocation(ko.unwrap(valueAccessor()));
                }
            }
            return this;
        }
    });
});


