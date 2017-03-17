define(['Magento_Checkout/js/model/quote'],function (quote) 
{
    "use strict";
    
    return function (shippingMethod) 
    {
    	if ('undefined' !== typeof dataLayer && 'undefined' !== typeof data)	
    	{
    		(function(dataLayer, jQuery, shippingMethod)
    		{
    			window.shippingMethod = shippingMethod;
    			
    			var method = '';
    			
    			if (shippingMethod && shippingMethod.hasOwnProperty('method_title'))
    	    	{
    	    		method = shippingMethod.method_title;
    	    	}
    			else 
    			{
    				console.log('Unable to determine shipping method');
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
    							'step': 1, 
    							'option': method
    						}
    					}
    				}
        		});
        		
    		})(dataLayer, jQuery, shippingMethod);
    	}
    	
        quote.shippingMethod(shippingMethod);
    }
});