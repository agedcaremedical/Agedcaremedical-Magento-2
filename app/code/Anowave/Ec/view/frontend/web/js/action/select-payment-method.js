define(['Magento_Checkout/js/model/quote'],function(quote) 
{
    'use strict';
    
    return function (paymentMethod) 
    {
    	if ('undefined' !== typeof dataLayer && 'undefined' !== typeof data)
    	{
    		(function(dataLayer, $)
    		{
    			/**
        		 * Empty default payment method by default
        		 */
        		var method = '';
        		
        		if (paymentMethod && paymentMethod.hasOwnProperty('title'))
        		{
        			/**
        			 * Set payment method
        			 */
        			method = paymentMethod.title;
        		}
        		else 
        		{
        			/**
        			 * By default send payment method as code
        			 */
        			method = paymentMethod.method;
        			
        			/**
        			 * Try to map payment method to user-friendly text representation
        			 */
        			if (paymentMethod.hasOwnProperty('method'))
        			{
        				var label = $('label[for="' + paymentMethod.method + '"]');
        				
        				if (label.length && label.find('>span').length > 0)	
        				{
        					method = label.find('>span').text();
        				}
        			}
        		}
        		
        		/**
        		 * Push checkout payment option to dataLayer
        		 */
        		dataLayer.push(
    			{
    				'event': 'checkoutOption',
    				'ecommerce': 
    				{
    					'checkout_option': 
    					{
    						'actionField': 
    						{
    							'step': 2, 
    							'option': method
    						}
    					}
    				}
        		});
        		
    		})(dataLayer, jQuery);
    	}
    	
        quote.paymentMethod(paymentMethod);
    }
});