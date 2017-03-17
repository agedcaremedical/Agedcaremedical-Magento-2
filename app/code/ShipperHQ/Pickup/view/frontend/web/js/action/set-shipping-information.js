/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }
            shippingAddress['extension_attributes']['delivery_date'] = $('#shipperhq_calendar').val();
            shippingAddress['extension_attributes']['time_slot'] = $('#shipperhq_timeslots').val();
            shippingAddress['extension_attributes']['location_id'] = $('#shipperhq_location').val();

            // pass execution to original action ('Magento_Checkout/js/action/set-shipping-information')
            var outcome = originalAction();

            var locationId = $('#shipperhq_location').val();
            if(locationId) {
                var populateAddressUrl = window.checkoutConfig.shipperhq_pickup.populate_location_address_url;
                var shipping_carrier_code = quote.shippingMethod().carrier_code;
                $.ajax({
                    type: 'GET',
                    url: populateAddressUrl,
                    data: {
                        'carrier': shipping_carrier_code,
                        'location_id': locationId
                    },
                    context: $('body')
                }).success(function (data) {

                    if (data.address) {
                        shippingAddress.city = data.address.city;
                        shippingAddress.postcode = data.address.zipcode;
                        shippingAddress.region = data.address.region;
                        shippingAddress.countryId = data.address.country;
                        shippingAddress.company = data.address.company;
                        var streetArray = [data.address.street1, data.address.street2];
                        shippingAddress.street = streetArray;
                        quote.shippingAddress(shippingAddress);

                    }
                });

            }
            quote.shippingAddress(shippingAddress);

            return outcome;

        });

    };
});