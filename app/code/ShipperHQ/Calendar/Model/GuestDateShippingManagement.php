<?php
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
 * @package ShipperHQ_Common
 * @copyright Copyright (c) 2015 Zowta LLC (http://www.ShipperHQ.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author ShipperHQ Team sales@shipperhq.com
 */
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShipperHQ\Calendar\Model;

use Magento\Quote\Model\QuoteIdMask;
use Magento\Quote\Model\QuoteIdMaskFactory;
use ShipperHQ\Calendar\Model\DateShippingProcessor;

/**
 * Shipping method management class for guest carts.
 */
class GuestDateShippingManagement implements \ShipperHQ\Calendar\Api\GuestDateShippingManagementInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;

    /**
     * @var DateShippingProcessor
     */
    private $dateShippingProcessor;

    /**
     * Constructs a date shipping method processor
     *
     * @param \ShipperHQ\Calendar\Model\DateShippingProcessor $dateShippingProcessor
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     */
    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        \ShipperHQ\Calendar\Model\DateShippingProcessor $dateShippingProcessor
    )
    {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->dateShippingProcessor = $dateShippingProcessor;
    }

    public function requestRates($cartId, \ShipperHQ\Calendar\Api\Data\DateShippingInformationInterface $dateShippingInformation)
    {
        /** @var $quoteIdMask QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');

        $unmasked =  (int) $quoteIdMask->getQuoteId();

        return $this->dateShippingProcessor->requestShippingRates(
            (int) $quoteIdMask->getQuoteId(), $dateShippingInformation);
    }

}