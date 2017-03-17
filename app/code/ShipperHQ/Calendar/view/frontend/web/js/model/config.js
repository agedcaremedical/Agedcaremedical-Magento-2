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
 * @copyright Copyright (c) 2016 Zowta LLC (http://www.ShipperHQ.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author ShipperHQ Team sales@shipperhq.com
 */
define(['ko', 'jquery', 'ShipperHQ_Calendar/js/model/timeslot'],
    function (ko, $, timeslot) {
        'use strict';
        var show_calendar = ko.observable(window.checkoutConfig.shipperhq_calendar.show_calendar);
        var loadConfigUrl = window.checkoutConfig.shipperhq_calendar.load_config_url;
        var request_rates_url = window.checkoutConfig.shipperhq_calendar.request_rates_url;
        var dateFormat = window.checkoutConfig.shipperhq_calendar.dateFormat;
        var datepickerFormat = window.checkoutConfig.shipperhq_calendar.datepickerFormat;
        var min_date = window.checkoutConfig.shipperhq_calendar.min_date;
        var max_date = window.checkoutConfig.shipperhq_calendar.max_date;
        var allowed_dates = window.checkoutConfig.shipperhq_calendar.allowed_dates;
        var date_selected = ko.observable(window.checkoutConfig.shipperhq_calendar.date_selected);
        var carrier_code = window.checkoutConfig.shipperhq_calendar.carrier_code;
        var carrier_id = window.checkoutConfig.shipperhq_calendar.carrier_id;
        var carrier_group_id = window.checkoutConfig.shipperhq_calendar.carrier_group_id;
        var timeslots = ko.observableArray([]);
        var show_timeslots = ko.observable(window.checkoutConfig.shipperhq_calendar.show_timeslots);
        var processing = false;
        return {
            processing: processing,
            show_calendar: show_calendar,
            loadConfigUrl: loadConfigUrl,
            request_rates_url: request_rates_url,
            dateFormat: dateFormat,
            datepickerFormat: datepickerFormat,
            min_date: min_date,
            max_date: max_date,
            allowed_dates: allowed_dates,
            date_selected: date_selected,
            carrier_code: carrier_code,
            carrier_id: carrier_id,
            carrier_group_id: carrier_group_id,
            timeslots: timeslots,
            show_timeslots: show_timeslots,
            updateConfig: function (config) {
                this.show_calendar(config.show_calendar);
                this.dateFormat = config.dateFormat;
                this.datepickerFormat = config.datepickerFormat;
                this.min_date = config.min_date;
                this.max_date = config.max_date;
                this.allowed_dates = config.allowed_dates;
                this.carrier_code = config.carrier_code;
                this.carrier_id = config.carrier_id;
                this.show_timeslots(config.show_timeslots);
                timeslot.rawData = config.timeslots;

                var tsdate = this.date_selected();
                if (!tsdate) {
                    tsdate = this.min_date;
                }
                timeslot.setTimeslots(timeslot.getTimeslotsForDate(tsdate));
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
                        self.updateConfig(data.config.shipperhq_calendar);
                    }
                    callback();
                });
            }
        };
    });