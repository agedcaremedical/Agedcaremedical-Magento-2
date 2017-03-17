<?php
/**
 * Anowave Magento 2 Google Tag Manager Enhanced Ecommerce (UA) Tracking
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Anowave license that is
 * available through the world-wide-web at this URL:
 * http://www.anowave.com/license-agreement/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category 	Anowave
 * @package 	Anowave_Ec
 * @copyright 	Copyright (c) 2017 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */

namespace Anowave\Ec\Preference;

class RemoveItem extends \Magento\Checkout\Controller\Sidebar\RemoveItem
{
	/**
	 * @var \Magento\Checkout\Model\Cart
	 */
	protected $cart = null;
	
	/**
	 * @var \Anowave\Ec\Helper\Data
	 */
	protected $dataHelper = null;
	
	public function __construct
	(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Checkout\Model\Sidebar $sidebar,
		\Psr\Log\LoggerInterface $logger,
		\Magento\Framework\Json\Helper\Data $jsonHelper,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Checkout\Model\Cart $cart,
		\Anowave\Ec\Helper\Data $dataHelper
	) 
	{
		parent::__construct($context, $sidebar, $logger, $jsonHelper, $resultPageFactory);
		
		$this->cart = $cart;
		
		$this->dataHelper = $dataHelper;
	}
	
	/**
     * Compile JSON response
     *
     * @param string $error
     * @return \Magento\Framework\App\Response\Http
     */
    protected function jsonResponse($error = '')
    {
        $response = $this->sidebar->getResponseData($error);
        
        $item = $this->cart->getQuote()->getItemById((int) $this->getRequest()->getParam('item_id'));
        
        if ($item instanceof \Magento\Quote\Api\Data\CartItemInterface) 
        {
        	$product = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Catalog\Model\Product')->load
        	(
        		$item->getProductId()
        	);
        	
        	$data = 
        	[
        		'event' 	=> 'removeFromCart',
        		'ecommerce' =>
        		[
        			'remove' =>
        			[
        				'products' =>
        				[
        					[
        						'id'  		=> $item->getProductId(),
        						'name' 		=> $item->getName(),
        						'quantity' 	=> $item->getQty(),
        						'price'		=> $item->getPrice(),
        						'brand'		=> $this->dataHelper->getBrand($product)
        					]
        				]
        			]
        		]
        	];
        	
        	/**
        	 * Get all product categories
        	 */
        	$categories = $product->getCategoryIds();
        		
        	if ($categories)
        	{
        		/**
        		 * Load last category
        		 */
        		$category = \Magento\Framework\App\ObjectManager::getInstance()->get('\Magento\Catalog\Model\Category')->load
        		(
        			end($categories)
        		);
        		
        		$data['ecommerce']['remove']['products'][0]['category'] = $this->dataHelper->getCategory($category);
        	}
        	
        	$response['dataLayer'] = $data;
        }
        
        return $this->getResponse()->representJson($this->jsonHelper->jsonEncode($response));
    }
}