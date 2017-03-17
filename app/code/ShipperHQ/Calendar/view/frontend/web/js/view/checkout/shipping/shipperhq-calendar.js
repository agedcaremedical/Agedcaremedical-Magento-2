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
    'mage/calendar',
    'ShipperHQ_Calendar/js/model/config',
    'ShipperHQ_Calendar/js/model/timeslot',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-service',
    'Magento_Checkout/js/model/resource-url-manager',
    'mage/storage'
], function ($, _, ko, Component, calendar, calendarConfig, timeslot, quote, shippingService, resourceUrlManager, storage) {
    'use strict';

    var myDate = ko.observable(null);
    var shouldShow = ko.computed(function () { return calendarConfig.show_calendar(); });
    var timeslots = ko.computed(function () { return timeslot.timeslots(); });
    var showTimeslots = ko.computed(function () { return calendarConfig.show_timeslots(); });
    var noSlots = ko.observable(timeslot.timeslots().length == 0);
    var shipping_method = null;
    var myTimeslot = ko.observable(null);

    return Component.extend({
        defaults: {
            template: 'ShipperHQ_Calendar/checkout/shipping/shipperhq-calendar'
        },
        myDate: myDate,
        noSlots: noSlots,
        myTimeslot: myTimeslot,
        shouldShow: shouldShow,
        timeslots: timeslots,
        showTimeslots: showTimeslots,
        shipping_method: shipping_method,
        initialize: function () {
            this._super();

            var self = this;

            timeslot.timeslots.extend({ rateLimit: 50 });
            timeslot.timeslots.subscribe(function (newValue) {
                this.noSlots(timeslot.timeslots().length == 0);
            }, this);

            quote.shippingMethod.subscribe(function (newValue) {
                if ((newValue === true) || (quote.shippingMethod() == null)) {
                    // no shipping method set yet, hide calendar
                    calendarConfig.show_calendar(false);
                    return; // and stop here
                }
                var method = newValue.carrier_code + '_' + newValue.method_code;
                if (method == this.shipping_method) {
                    return;
                }
                this.shipping_method = method;

                // Shipping method set, reload calendar details
                calendarConfig.reloadConfig(function () {
                    calendarConfig.date_selected(calendarConfig.min_date);

                }, quote.shippingMethod().carrier_code);

            }, this);

            shippingService.isLoading.subscribe(function (status) {
                if (calendarConfig.processing) {
                    return; // Don't do anything since we triggered the update
                }
                if (status == false) { // done loading rates

                    if (quote.shippingMethod() == null) {
                        // no shipping method set yet
                        return; // stop here
                    }
                    calendarConfig.reloadConfig(function () {
                        // handle any calender detail updates needed here
                    }, quote.shippingMethod().carrier_code);
                }
            }, this);

            var updateTimeslots = function(newvalue) {
                if (newvalue == null) {
                    timeslot.setTimeslots([]);
                    return;
                }
                var tslots = timeslot.getTimeslotsForDate(newvalue);
                timeslot.setTimeslots(tslots);
            };

            updateTimeslots(calendarConfig.date_selected());

            this.myDate.subscribe(function (newvalue) {
                if (calendarConfig.show_timeslots()) {
                    newvalue = $.datepicker.formatDate(calendarConfig.datepickerFormat, newvalue);;
                    updateTimeslots(newvalue);
                }
            });

            calendarConfig.date_selected.subscribe(function (newvalue) {
                if (this.myDate() != newvalue) {
                    $('#shipperhq_calendar').datepicker("setDate", newvalue);
                    if (calendarConfig.show_timeslots()) {
                        updateTimeslots(newvalue);
                    }
                }
            }, this);

            ko.bindingHandlers.shq_datepicker = {
                init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
                    ko.utils.registerEventHandler(element, "change", function () {
                        calendarConfig.processing = true;
                        var observable = valueAccessor();
                        observable($(element).datepicker("getDate"));

                        //be careful as the datepicker can use the locale of browser for dates so include only date text
                        var dateText = $(element).datepicker({dateFormat: calendarConfig.datepickerFormat}).val();
                        //  ideally pass to a function here onChangeSelectedDate(carriergroupId, carriergroupInsert, carrierCode);
                        shippingService.isLoading(true);

                        //SHQ16-1770
                        var address = quote.shippingAddress();
                        var quoteId = quote.getQuoteId();

                        var params = (resourceUrlManager.getCheckoutMethod() == 'guest') ? {cartId: quote.getQuoteId()} : {};
                        var urls = {
                            'guest': '/guest-carts/:cartId/guestrequest-calendar-rates',
                            'customer': '/carts/mine/request-calendar-rates'
                        };
                        var serviceUrl = resourceUrlManager.getUrl(urls, params);
                        var payload = JSON.stringify({
                                date_shipping_information: {
                                    carriergroup_id: '',
                                    carrier_code: calendarConfig.carrier_code,
                                    carrier_id: calendarConfig.carrier_id,
                                    date_selected: dateText,
                                    cart_id: quoteId,
                                    address: {
                                        'street': address.street,
                                        'city': address.city,
                                        'region_id': address.regionId,
                                        'region': address.region,
                                        'country_id': address.countryId,
                                        'postcode': address.postcode,
                                        'email': address.email,
                                    }
                                }
                            }
                        );

                        storage.post(
                            serviceUrl, payload, false
                        ).done(
                            function (result) {
                                shippingService.setShippingRates(result);
                            }
                        ).fail(
                            function (response) {
                                //TODO something
                                // shippingService.setShippingRates([]);
                                // errorProcessor.process(response);
                            }
                        ).always(
                            function () {
                                shippingService.isLoading(false);
                                calendarConfig.processing = false;
                            }
                        );
                    });
                },
                update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
                    if (calendarConfig.processing) {
                        return; // Don't do anything since we triggered the update
                    }
                    if(!calendarConfig.show_calendar()) {
                        return;
                    }
                    var $el = $(element);
                    //load config
                    var dateselected = calendarConfig.date_selected();
                    if (dateselected == undefined || dateselected == null) {
                        dateselected = '';
                    }
                    var options = {
                        showOn: "button",
                        buttonText: "",
                        beforeShowDay: function (date) {
                            //ideally move to a function
                            var dmy = $.datepicker.formatDate(calendarConfig.datepickerFormat, date);
                            var alloweddates = calendarConfig.allowed_dates;
                            var found = [false, "", "unAvailable"];
                            for (var key in alloweddates) {
                                if (dmy == alloweddates[key]) {
                                    found = [true, "", "Available"];
                                    break;
                                }
                            }
                            return found;
                        }
                    }
                    $el.datepicker(options);
                    $el.datepicker('option', 'dateFormat', calendarConfig.datepickerFormat);
                    $el.datepicker('option', 'minDate', calendarConfig.min_date);
                    $el.datepicker('option', 'maxDate', calendarConfig.max_date);
                    $el.datepicker('setDate', dateselected);
                }
            };

            return this;
        }

    });

});


