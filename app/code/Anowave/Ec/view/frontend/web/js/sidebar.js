/**
 * Sidebar augment
 * 
 * @copyright Anowave 2017
 * @author Anowave
 */
define(function () 
{
    'use strict';

    return function (target) 
    { 	
    	target.prototype._removeItemAfter = function(element, response)
    	{
    		if (response.hasOwnProperty('dataLayer') && 'undefined' !== typeof dataLayer)
    		{
    			dataLayer.push(response.dataLayer);
    		}
    	}
    	
    	return target;
    };
});