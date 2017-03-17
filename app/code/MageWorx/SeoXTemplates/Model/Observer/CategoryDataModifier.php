<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\SeoXTemplates\Model\Observer;

use MageWorx\SeoXTemplates\Model\ResourceModel\Template\Product\CollectionFactory;
use MageWorx\SeoXTemplates\Model\DynamicRenderer\Category as Renderer;

/**
 * Observer class for product template apply proccess
 */

class CategoryDataModifier implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $dynamicRenderer;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var  \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(
        Renderer $dynamicRenderer,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry
    ) {
    
        $this->dynamicRenderer = $dynamicRenderer;
        $this->request = $request;
        $this->registry     = $registry;
    }

    /**
     * Modify category data and meta head
     * Event: layout_generate_blocks_after
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        if ('catalog_category_view' == $this->request->getFullActionName()) {
            /**
             * @var \Magento\Catalog\Model\Category
             */
            $category = $this->registry->registry('current_category');
            if (is_object($category)) {
                $this->dynamicRenderer->modifyCategoryTitle($category);
                $this->dynamicRenderer->modifyCategoryMetaDescription($category);
                $this->dynamicRenderer->modifyCategoryDescription($category);
            }
        }
    }
}
