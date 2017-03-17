/**
 * Private content push
 * 
 * @copyright Anowave
 * @package Anowave_Ec
 */
define(['jquery'], function ($) 
{
	return (function()
	{
		return {
			bind: function(response, dataLayer)
			{
				if ('undefined' !== typeof dataLayer)
				{
					$.each(response, function(index, data)
					{
						dataLayer.push(data);
					});
				}
			}
		}
	})();
});